<?php

namespace MessageWebService;

use MessageWebService\JRequest\JsonRequest;
use Illuminate\Database\Eloquent\Model;

class V_Message extends Model{
    //
    protected $table = 'v_messages';

    public function getMessages(JsonRequest $request){
        $messages = V_Message::where([
        ["appid", "=",  $request->getAppId()],
        ["modid", "=", $request->getModulId()],
        ["lang","LIKE", $request->getAppLang()]
        ])
        ->whereIn("idmsg", $request->getRequItems())->get();

    }

}
