<?php

namespace MessageWebService\Http\Controllers;

use MessageWebService\Exceptions\MessageNotFoundException;
use MessageWebService\Exceptions\MyException;
use MessageWebService\JResponse\JsonResponseItem;
use MessageWebService\Language;
use MessageWebService\JRequest\JsonRequest;
use MessageWebService\JResponse\JSonResponse;
use MessageWebService\Exceptions\RequestNotValidException;
use MessageWebService\Providers\CheckClassProvider;
use MessageWebService\V_Message;
use MessageWebService\Http\Controllers\Auth\AppLoginController;
use Nikapps\Pson\Pson;
use MessageWebService\Providers\ClassChanger;


class MessageController extends Controller {

    function processRequest($request, JsonResponse &$jresponse) {
        try {
            $p = new Pson();

            CheckClassProvider::checkJsontoJsonRequest($jresponse, $request);
            if($jresponse->getSuccess()) {

                $jrequest = $p->fromJson("MessageWebService\JRequest\JsonRequest", $request);


                $jrequest = ClassChanger::changeClass($jrequest, "MessageWebService\JRequest\JsonRequest");


                $this->getMessages($jrequest, $jresponse);
            }
            return $jresponse;

        } catch (Exception $e) {
            $me = new MyException($e->getMessage(), 400);
            $jresponse->addError($me);
            return $jresponse;
        }
    }



    public function getMessages(JsonRequest $request, JsonResponse &$response){
        try{
            MessageController::validateRequest($request);

            AppLoginController::getInstance()->identify($response, $request);


            return $this->getMessagesFromRequest($response, $request);
        }catch(MyException $afe){
            $response->addError($afe);
        }


    }

    public static function getMessage($appid, $modulid, $lang, $msgid){
        $message = V_Message::where([
            ['appid', $appid],
            ['modid', $modulid],
            ['lang', $lang],
            ['idmsg', $msgid]
        ])->get();

        if(empty($message->first())){
            throw new MessageNotFoundException(MessageController::getInternalMessage($lang, 8). " ID: ". $msgid);
        }

        return $message->first()->message;
    }

    public static function getInternalMessage($lang, $msgid){

        if(is_numeric($lang)) {
            $langages = Language::all();
            foreach ($langages as $language){
                if($lang == $language->id){
                    $lang = $language->lang_code;
                    break;
                }
            }
            if(is_numeric($lang)){
                $lang = "pt";
            }
        }

        return self::getMessage(2,2, $lang, $msgid);
    }

    /**
     * @param JsonRequest $request
     * @return mixed
     */
    public function getMessagesFromRequest(JSonResponse &$response, JsonRequest $request) {
        $messages = \MessageWebService\V_Message::where([['appid', $request->getAppId()], ['lang', $request->getAppLang()], ['modid', $request->getModulId()]

        ])->wherein('idmsg', $request->getRequItems())->get();

        $idsnotfound = array();
        if($messages->count() != count($request->getRequItems())){
            foreach ($request->getRequItems() as $msgid){
                try {
                    MessageController::getMessage($request->getAppId(), $request->getModulId(), $request->getAppLang(), $msgid );
                }catch (MyException $me){
                    $idsnotfound[] = $msgid;
                    $response->addError($me);
                }
            }
        }

        foreach($messages as $key => $message) {
            if (!in_array($message->idmsg, $idsnotfound)) {

                $item = new JsonResponseItem();
                $item->setIdmsg($message->idmsg);
                $item->setMsg($message->message, $request->getRequItemsReplace()[$key]);
                $item->setType($message->type);
                $response->addResponseItem($item);
            }
        }

    }

    private function validateRequest(JsonRequest $request){
        if(MessageController::findLang($request->getAppLang())){
            throw new RequestNotValidException(MessageController::getInternalMessage(3, 2));
        }

        if(!is_numeric($request->getAppId())){
            throw new RequestNotValidException(MessageController::getInternalMessage($request->getAppLang(), 2));
        }

        if(!is_numeric($request->getModulId())){
            throw new RequestNotValidException(MessageController::getInternalMessage($request->getAppLang(), 3));
        }

        foreach ($request->getRequItems() as $msgid){
            if(!is_numeric($msgid)){
                throw new RequestNotValidException(MessageController::getInternalMessage($request->getAppLang(), 4));
            }
        }

        return true;

    }


    private static function findLang($lang) {
        if (isset($lang)) {
            $lang = Language::where('lang_code', $lang)->first();
            return $lang->count == 1;
        }else{
            throw new RequestNotValidException(MessageController::getInternalMessage("en",10));
        }
    }


}
