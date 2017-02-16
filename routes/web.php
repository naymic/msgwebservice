<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use Nikapps\Pson\Pson;
use \App\JRequest\JsonRequest;
use \App\JResponse\JsonResponse;
use \App\Providers\ClassChanger;
use \App\Exceptions\MyException;
use App\Http\Controllers\MessageController;


Route::get('/phpinfo', function(){
    return phpinfo();
});

Route::get('/admin', function(){

});

Route::get('/{request}', function ($request) {
    $jresponse = new JSonResponse();
    $msgController = new MessageController();

    $jresponse = $msgController->processRequest($request, $jresponse);

    if(isset($jresponse->getHtmlErrorCodes()[0])) {
        return response()->json($jresponse, $jresponse->getHtmlErrorCodes()[0]);
    }else{
        return response()->json($jresponse);
    }
});

Route::get('/', function(){
    return "hello world Laravel";
});


