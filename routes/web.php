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

use MessageWebService\JsonResponse\JSonResponse;
use MessageWebService\Exceptions\RequestNotValidException;
use MessageWebService\Http\Controllers\MessageController;




Auth::routes();

Route::group(['middleware' =>  'auth'], function(){

    /** Aplication */
    Route::get('/application', 'CrudApplicationController@index');
    Route::get('/application', 'CrudApplicationController@index');
    Route::get('/application/create', 'CrudApplicationController@create');
    Route::post('/application', 'CrudApplicationController@store');
    Route::get('/application/{id}', 'CrudApplicationController@show');
    Route::get('/application/{id}/edit', 'CrudApplicationController@edit');
    Route::put('/application/{id}', 'CrudApplicationController@update');
    Route::delete('/message/{id}', 'CrudApplicationController@destroy');


    /** Modules */
    Route::get('/module', 'CrudModuleController@index');
    Route::get('/module', 'CrudModuleController@index');
    Route::get('/module/create', 'CrudModuleController@create');
    Route::post('/module', 'CrudModuleController@store');
    Route::get('/module/{id}', 'CrudModuleController@show');
    Route::get('/module/{id}/edit', 'CrudModuleController@edit');
    Route::put('/module/{id}', 'CrudModuleController@update');
    Route::delete('/module/{id}', 'CrudModuleController@destroy');


    /** Messages */
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




Route::get('/admin', function(){

});

Route::get('/{request}', function ($request) {
    $jresponse = new JSonResponse();
    $msgController = new MessageController();

    $jresponse = $msgController->processRequest($request, $jresponse);

    if(isset($jresponse->getHtmlErrorCodes()[0])) {
        return response()->json($jresponse, $jresponse->getHtmlErrorCodes()[0]);
    }else{
        return response()->json($jresponse, 200, ['Content-Type' => 'application/json; charset=utf-8' ]);
    }
});

Route::get('/', function(){

    return View::make('welcome');

    /*$jresponse = new JSonResponse();
    $jresponse->addError(new RequestNotValidException(MessageController::getInternalMessage('en', 10)));

    return response()->json($jresponse, $jresponse->getHtmlErrorCodes()[0]);*/
});






Auth::routes();

Route::get('/home', 'HomeController@index');
