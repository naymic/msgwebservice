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

use \MessageWebService\JResponse\JSonResponse;
use MessageWebService\Exceptions\RequestNotValidException;
use MessageWebService\Http\Controllers\MessageController;


Auth::routes();

Route::group(['middleware' =>  'auth'], function(){
    Route::get('/message', 'CrudMessageController@index');
    Route::get('/message/create', 'CrudMessageController@create');
    Route::post('/message', 'CrudMessageController@store');
    Route::get('/message/{id}', 'CrudMessageController@show');
    Route::get('/message/{id}/edit', 'CrudMessageController@edit');
    Route::put('/message/{id}', 'CrudMessageController@update');
    Route::delete('/message/{id}', 'CrudMessageController@destroy');

    //Ajax
    Route::get('/ajax/message/application/{id}',  'CrudMessageController@ajaxApplication');

});


Route::get('/home', 'HomeController@index');
Route::get('/home/{token}', 'HomeController@index');


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
    $jresponse = new JSonResponse();
    $jresponse->addError(new RequestNotValidException(MessageController::getInternalMessage('en', 10)));

    return response()->json($jresponse, $jresponse->getHtmlErrorCodes()[0]);
});





