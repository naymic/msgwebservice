<?php

namespace App\Http\Controllers;

use App\Exceptions\MessageNotFoundException;
use App\Exceptions\MyException;
use App\JResponse\JsonResponseItem;
use App\Language;
use App\JRequest\JsonRequest;
use App\JResponse\JSonResponse;
use App\Exceptions\RequestNotValidException;
use App\V_Message;
use App\Http\Controllers\Auth\AppLoginController;
use Nikapps\Pson\Pson;
use App\Providers\ClassChanger;


class MessageController extends Controller {

    function processRequest($request, JsonResponse &$jresponse) {
        try {
            $p = new Pson();
            $jrequest = $p->fromJson("App\JRequest\JsonRequest", $request);
            $jrequest = ClassChanger::changeClass($jrequest, "App\JRequest\JsonRequest");


            $this->getMessages($jrequest, $jresponse);
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
        return self::getMessage(2,2, $lang, $msgid);
    }

    /**
     * @param JsonRequest $request
     * @return mixed
     */
    public function getMessagesFromRequest(JSonResponse &$response, JsonRequest $request) {
        $messages = \App\V_Message::where([['appid', $request->getAppId()], ['lang', $request->getAppLang()], ['modid', $request->getModulId()]

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

        foreach($messages as $message) {
            if (!in_array($message->idmsg, $idsnotfound)) {

                $item = new JsonResponseItem();
                $item->setIdmsg($message->idmsg);
                $item->setMsg($message->message);
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


    private static function findLang($lang){
       $lang = Language::where('lang_code', $lang)->first();
       return $lang->count == 1;
    }


}
