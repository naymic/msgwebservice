<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MessageWebService\Http\Controllers\MessageController;
use MessageWebService\JsonResponse\JSonResponse;
use Nikapps\Pson\Pson;

class JsonTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPsonTransform(){
        $p = new Pson();
        $request = $p->fromJson('MessageWebService\JRequest\JsonRequest','{"appid":1,"apptoken":"msgIstSoCool!-","modulid":1,"applang":"pt","requitems":[1,2,3]}');
        self::assertEquals(1, $request->getAppId());
        self::assertEquals("msgIstSoCool!-", $request->getAppToken());
        self::assertEquals(1, $request->getModulId());
        self::assertEquals("pt", $request->getAppLang());
        self::assertEquals(array(1,2,3), $request->getRequItems());

    }

     function testJsonRequest(){
        $response = new JsonResponse();
        $msgController = new MessageController();
        $json = '{"appid":1,"apptoken":"msgIstSoCool!-","modulid":1,"applang":"pt","requitems":[1,2,3],"requitemsreplace":[[],[],[]]}';
       $msgController->processRequest($json, $response);

       self::assertTrue($response->getSuccess());
       self::assertEquals(3, count($response->getResponseItems()));
       self::assertEquals(0, count($response->getHtmlErrorCodes()));
       self::assertEquals(0, count($response->getErrors()));
     }


    function testIncompleteJsonRequest(){
        $response = new JsonResponse();
        $msgController = new MessageController();
        $json = '{"appid":1,"appoken":"msgIstSoCool!-","modulid":1,"applng":"pt","requitems":[1,2,3],"requitemsreplace":[[],[],[]]}';
        $msgController->processRequest($json, $response);

        self::assertFalse($response->getSuccess());
        self::assertEquals(0, count($response->getResponseItems()));
        self::assertEquals(2, count($response->getHtmlErrorCodes()));
        self::assertEquals(2, count($response->getErrors()));

        self::assertEquals(400, $response->getHtmlErrorCodes()[0]);
        self::assertEquals("Please verifiy your request, it doesn't contains: apptoken", $response->getErrors()[0]);
        self::assertEquals(400, $response->getHtmlErrorCodes()[1]);
        self::assertEquals("Please verifiy your request, it doesn't contains: applang", $response->getErrors()[1]);

    }

    function testReplaceJsonRequest(){
        $response = new JsonResponse();
        $msgController = new MessageController();
        $json = '{"appid":1,"apptoken":"msgIstSoCool!-","modulid":1,"applang":"pt","requitems":[1,2,43],"requitemsreplace":[[],[],["test1", "test2"]]}';
        $msgController->processRequest($json, $response);

        self::assertTrue($response->getSuccess());
        self::assertEquals(3, count($response->getResponseItems()));
        self::assertEquals("This is a test test1 replace test2 message", $response->getResponseItems()[2]->getMsg());

    }


}
