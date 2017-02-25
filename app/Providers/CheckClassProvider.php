<?php

namespace MessageWebService\Providers;

use MessageWebService\Http\Controllers\MessageController;
use Illuminate\Support\ServiceProvider;
use MessageWebService\JResponse\JSonResponse;
use ReflectionClass;
use MessageWebService\Exceptions\RequestNotValidException;

class CheckClassProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public static function checkJsontoJsonRequest(JsonResponse &$response, $jsonString){
        $reflector = new ReflectionClass('\MessageWebService\JRequest\JsonRequest');

        $properties = $reflector->getDefaultProperties();
        foreach ($properties as $key => $value){
            if(!strpos($jsonString,'"'.$key.'"')){
                $response->addError(new RequestNotValidException(MessageController::getInternalMessage("en",9). $key));
            }
        }


    }
}
