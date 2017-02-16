<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\MessageController;
use App\V_Message;
use App\JRequest\JsonRequest;
use App\JResponse\JsonResponse;
use App\Http\Controllers\Auth\AppLoginController;
use App\Exceptions\MyException;

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


}
