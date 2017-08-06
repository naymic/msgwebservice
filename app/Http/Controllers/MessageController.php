<?php

namespace MessageWebService\Http\Controllers;

use MessageWebService\Exceptions\EmptyRequestException;
use MessageWebService\Exceptions\MessageNotFoundException;
use MessageWebService\Exceptions\MyException;
use MessageWebService\JsonResponse\JsonResponseItem;
use MessageWebService\Language;
use MessageWebService\JsonRequest\JsonRequest;
use MessageWebService\JsonResponse\JSonResponse;
use MessageWebService\Exceptions\RequestNotValidException;
use MessageWebService\Module;
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
        }catch (EmptyRequestException $ere){
            $response->addInfoMessage($ere->getMessage());
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
            throw new MessageNotFoundException(self::getInternalMessage($lang, 8). " ID: ". $msgid);
        }

        return $message->first()->message;
    }

    public static function getInternalMessage($lang, $msgid){

        if(is_numeric($lang)) {
            $lang = MessageController::getLangFromInt($lang);
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

                if(isset($request->getRequItemsReplace()[$key])) {
                    $item->setMsg($message->message, $request->getRequItemsReplace()[$key]);
                }else{
                    $item->setMsg($message->message);
                }
                $item->setType($message->type);
                $response->addResponseItem($item);
            }
        }


    }

    private function validateRequest(JsonRequest $request){
        if(empty($request->getAppId())){
            throw new RequestNotValidException(MessageController::getInternalMessage(2,15));
        }

        if(empty($request->getModulId())){
            throw new RequestNotValidException(MessageController::getInternalMessage(2,16));
        }

        if( empty($request->getRequItems()) || count($request->getRequItems()) == 0){
            throw new EmptyRequestException(MessageController::getInternalMessage(2,17));
        }


        if(strlen($request->getAppLang()) !=2 || !MessageController::findLang($request->getAppLang())){
            throw new RequestNotValidException(MessageController::getInternalMessage(2, 14));
        }

        if($request->getAppId() == null || !is_numeric($request->getAppId())){
            throw new RequestNotValidException(MessageController::getInternalMessage($request->getAppLang(), 2));
        }

        if(!is_numeric($request->getModulId())){
            throw new RequestNotValidException(MessageController::getInternalMessage($request->getAppLang(), 3));
        }else{
            if(!$this->checkModulId($request->getModulId())){
                throw new RequestNotValidException(MessageController::getInternalMessage($request->getAppLang(), 13 ));
            }
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
            return isset($lang);
        }else{
            throw new RequestNotValidException(MessageController::getInternalMessage("en",10));
        }
    }


    private function checkModulId($appid){
            $module = Module::where('applications_id', $appid)->first();
            return isset($module);
    }

    private static function getLangFromInt($langCode){
        $langages = Language::all();
        $lang = "pt";
        foreach ($langages as $language){
            if($langCode == $language->id){
                $lang = $language->lang_code;
                break;
            }
        }

        return $lang;
    }




}
