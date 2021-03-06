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

class DatabaseTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */



    public function testGetMessagesFromDatabase(){
        $response = new JsonResponse();
        $request = self::getRequest();

        $msgController = new MessageController();
        $msgController->getMessagesFromRequest($response, $request);
        //$messages = V_Message::all();

        self::assertFalse(empty($response->getResponseItems()));
        foreach($response->getResponseItems() as $message){
            switch($message->idmsg){
                case 1:
                    self::assertEquals("Autenticação foi um sucesso!", $message->getMsg());
                    break;
                case 2:
                    self::assertEquals("Autenticação não foi autorizada. Verifique seus dados!", $message->getMsg());
                    break;

                case 3:
                    self::assertEquals("A requisição em não está correta, por favor verifique!", $message->getMsg());
                    break;
            }

        }
    }

    public function testGetUnexistentMessagesFromDatabase(){
        $response = new JsonResponse();
        $request = self::getRequest();
        $request->setRequItems(array(-1,3,-2,5));

        $msgController = new MessageController();
         $msgController->getMessagesFromRequest($response, $request);

        self::assertEquals("3",  $response->getResponseItems()[0]->getIdMsg());
        self::assertEquals("A requisição em não está correta, por favor verifique!",  $response->getResponseItems()[0]->getMsg());
        self::assertEquals("ERROR",  $response->getResponseItems()[0]->getType());

        self::assertEquals("5",  $response->getResponseItems()[1]->getIdMsg());
        self::assertEquals("Por favor informa um caso de uso!",  $response->getResponseItems()[1]->getMsg());
        self::assertEquals("ERROR",  $response->getResponseItems()[1]->getType());

        self::assertFalse($response->getSuccess());
        self::assertEquals("Mensagem não encontrado. ID: -1", $response->getErrors()[0]);
        self::assertEquals("Mensagem não encontrado. ID: -2", $response->getErrors()[1]);
    }

    public function testGetUnexistentLangFromDatabase(){
        $response = new JsonResponse();
        $request = self::getRequest();
        $request->setAppLang("asjkl");

        $msgController = new MessageController();
        $msgController->getMessages($request, $response);

        self::assertFalse($response->getSuccess());
        self::assertEquals("Linguagem não existe, por favor informa apenas o código com duas letras! Ex.: PT", $response->getErrors()[0]);
    }

    public function testEmptyRequest(){
        $response = new JsonResponse();
        $request = self::getRequest();
        $request->setRequItems(array());


        //Check empty message id array
        $msgController = new MessageController();
        $msgController->getMessages($request, $response);

        self::assertTrue($response->getSuccess());
        self::assertEquals("Não existem mensagens para buscar.", $response->getInfoMessages()[0]);

        //Check null request items
        $response = new JsonResponse();
        $request->setRequItems(null);
        $msgController->getMessages($request, $response);

        self::assertTrue($response->getSuccess());
        self::assertEquals("Não existem mensagens para buscar.", $response->getInfoMessages()[0]);
    }
}
