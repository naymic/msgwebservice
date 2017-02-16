<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\MessageController;
use App\JResponse\JSonResponse;
use Nikapps\Pson\Pson;

class JsonTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPsonTransform(){
        $p = new Pson();
        $request = $p->fromJson('App\JRequest\JsonRequest','{"appid":1,"apptoken":"msgIstSoCool!-","modulid":1,"applang":"pt","requitems":[1,2,3]}');
        self::assertEquals(1, $request->getAppId());
        self::assertEquals("msgIstSoCool!-", $request->getAppToken());
        self::assertEquals(1, $request->getModulId());
        self::assertEquals("pt", $request->getAppLang());
        self::assertEquals(array(1,2,3), $request->getRequItems());

    }

     function testJsonRequest(){
        $response = new JsonResponse();
        $msgController = new MessageController();
        $json = '{"appid":1,"apptoken":"msgIstSoCool!-","modulid":1,"applang":"pt","requitems":[1,2,3]}';
       $msgController->processRequest($json, $response);

       print_r($response);
    }


}
