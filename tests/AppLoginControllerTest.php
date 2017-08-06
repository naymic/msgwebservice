<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MessageWebService\Http\Controllers\MessageController;
use MessageWebService\V_Message;
use MessageWebService\JsonRequest\JsonRequest;
use MessageWebService\JsonResponse\JsonResponse;
use MessageWebService\Http\Controllers\Auth\AppLoginController;
use MessageWebService\Exceptions\MyException;


class AppLoginControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTokenAuth(){
        $response = new JsonResponse();
        $request = self::getRequest();

        //Correct Autentication
        try {
            AppLoginController::getInstance()->identify($response, $request);

            self::assertTrue($response->getSuccess());
        }catch(MyException $me){
            $response->addError($me);
        }
    }

    public function testEmptyToken(){
        $response = new JsonResponse();
        $request = self::getRequest();

        //Token is not set
        $request->setAppToken("");

        try{
            AppLoginController::getInstance()->identify($response, $request);
        }catch(MyException $me) {
            $response->addError($me);
        }

        self::assertFalse($response->getSuccess());
        self::assertEquals('Por favor insere um token válido!', $response->getErrors()[0]);
    }

    public function testFalseToken(){
        $response = new JsonResponse();
        $request = self::getRequest();

        $request->setAppToken("jklj klj klj klj klç");
        try{
            AppLoginController::getInstance()->identify($response, $request);
        }catch(MyException $me) {
            $response->addError($me);
        }

        self::assertFalse($response->getSuccess());
        self::assertEquals('Autenticação com o token falhou.', $response->getErrors()[0]);
    }


    public function testFalseAppId(){
        $response = new JsonResponse();
        $request = self::getRequest();



        //Applicação não existe
        //Token is not set
        $request = self::getRequest();
        $request->setAppId("-1");
        try{
            AppLoginController::getInstance()->identify($response, $request);
        }catch(MyException $me) {
            $response->addError($me);
        }

        self::assertFalse($response->getSuccess());
        self::assertEquals('Applicação não encontrado, por favor verifique o ID da aplicação!', $response->getErrors()[0]);
    }
}
