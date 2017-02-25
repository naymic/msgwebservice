<?php

namespace MessageWebService\Http\Controllers;

use MessageWebService\Application;
use MessageWebService\Exceptions\RequestNotValidException;
use MessageWebService\Language;
use MessageWebService\Message;
use MessageWebService\Module;
use MessageWebService\V_Message;
use MessageWebService\MessageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Type;

class CrudMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $message = $request->input('message', '');
        $application_id = $request->input('application_id', 'null');
        $modul_id = $request->input('modul_id', 'null');
        $lang_code = $request->input('lang_code', 'null');
        $type = $request->input('type', 'null');

        $messages = DB::table('v_messages')->where('message', 'LIKE', '%'. $message .'%');

        if($application_id != 'null'){
            $messages->where('appid', $application_id);
            $modules = DB::table('modules')->where('applications_id', $application_id)->get();
        }else{
            $modules = Module::all();
        }

        if($modul_id != 'null'){
            $messages->where('modid', $modul_id);
        }

        if($lang_code != 'null'){
            $messages->where('lang', 'LIKE' , $lang_code);
        }

        if($type != 'null'){
            $messages->where('type', 'LIKE' , $type);
        }

        return view('messages/index', ['messages' => $messages->orderBy('appid','ASC')->orderBy('modid','ASC')->orderBy('idmsg')->paginate(10),
                                        'applications' => Application::all(),
                                        'modules' => $modules,
                                        'languages' => Language::all(),
                                        'application_id' => $application_id,
                                        'types' => MessageType::all(),
                                        'type' => $type,
                                        'modul_id' => $modul_id,
                                        'lang_code' => $lang_code,
                                        'message' => $message,
                                        'method' => 'get',
                                        'submit_value'=> 'Search',
                                        'url_add' => '']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(){
        return view('messages/form',[ 'applications' => Application::all(),
                                      'modules' => Module::all(),
                                      'languages' => Language::all(),
                                      'types' => MessageType::all(),
                                      'type' => '',
                                      'application_id' => '',
                                      'modul_id' => '',
                                      'lang_code' => '',
                                      'message' => '',
                                      'method' => 'post',
                                      'submit_value'=> 'Save',
                                      'url_add' => '']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request){

        $modul_id = $request->input('modul_id', 'null');
        $lang_code = $request->input('lang_code', 'null');
        $message = $request->input('message',  'null');
        $type = $request->input('type',  'null');


            $msg = new Message();


            $msgid = Message::where('modules_id', $modul_id)->orderBy('idmsg', 'DESC')->firstOrFail();
            $msg->idmsg  = $msgid->idmsg+1;
            $msg->modules_id = $modul_id;
            $lang = Language::where('lang_code', $lang_code)->firstOrFail();
            $msg->languages_id =$lang->id;
            $type = MessageType::where('type',$type)->firstOrFail();
            $msg->message_types_id = $type->id;
            $msg->message = $message;

            $msg->save();

            return view('messages/saved',['message' => MessageController::getInternalMessage(3, 11),
                                          'button_value' => 'Back to Messages',
                                          'url' => '/message/']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $message = V_Message::where('id',$id)->firstOrFail();

        if(!empty($message->id)) {
            return view('messages/form',[ 'applications' => Application::all(),
                                        'modules' => Module::all(),
                                        'languages' => Language::all(),
                                        'types' => MessageType::all(),
                                        'type' => $message->type,
                                        'application_id' => $message->appid,
                                        'modul_id' => $message->modid,
                                        'lang_code' => $message->lang,
                                        'message' => $message->message,
                                        'method' => 'put',
                                        'submit_value'=> 'Save',
                                        'url_add' => '/'.$message->id]);
        }else{
            return view('errors.400', ['info' => MessageController::getInternalMessage(3, 8) ]);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id){
        $application_id = $request->input('application_id', 'null');
        $modul_id = $request->input('modul_id', 'null');
        $lang_code = $request->input('lang_code', 'null');
        $message = $request->input('message',  'null');
        $type = $request->input('type',  'null');
        if($application_id == 'null' || $modul_id == 'null' || $lang_code == 'null' || $message == '' || $type == ''){
            return redirect()->route('/message',[$id]);
        }else{
            $msg = new Message();
            $msg->id = $id;

            $msgid = Message::where('modules_id', $modul_id)->orderBy('idmsg', 'DESC')->firstOrFail();
            $msg->idmsg  = $msgid->idmsg;
            $msg->modules_id = $modul_id;
            $lang = Language::where('lang_code', $lang_code)->firstOrFail();
            $msg->languages_id =$lang->id;
            $type = MessageType::where('type',$type)->firstOrFail();
            $msg->message_types_id = $type->id;
            $msg->message = $message;

            $msg->where('id', $id)->update(['idmsg' => $msgid->msgid+1,
                                       'modules_id' => $modul_id,
                                       'languages_id' => $lang->id,
                                       'message_types_id' => $type->id,
                                       'message' => $message,
            ]);

            return view('messages/saved',['message' => MessageController::getInternalMessage(3, 11),
                                            'button_value' => 'Back to Messages',
                                            'url' => '/message']);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id){
        Message::destroy($id);

        return view('defaults/delete');
    }


    public function ajaxApplication($application_id){
        $modules = Module::where('applications_id', $application_id)->get();
        return view('messages/modules_form',['modules' => $modules, 'modul_id' => 'null']);
    }
}
