<?php

use \Illuminate\Foundation\Testing\ParentTestCase;
use MessageWebService\JsonRequest\JsonRequest;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost:8000';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }


    public function getRequest(): JsonRequest{
        $request = new JsonRequest();
        $request->setAppId(1);
        $request->setAppLang("pt");
        $request->setAppToken("msgIstSoCool!-");
        $request->setModulId(1);
        $request->setRequItems(array(1,2,3));
        $request->setRequItemsReplace(array(array(),array(),array()));
        return $request;
    }


}
