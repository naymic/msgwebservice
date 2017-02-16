<?php

namespace App\Providers;

use App\Http\Controllers\MessageController;
use Illuminate\Support\ServiceProvider;
use App\JResponse\JSonResponse;
use ReflectionClass;
use App\Exceptions\RequestNotValidException;

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
        $reflector = new ReflectionClass('\App\JRequest\JsonRequest');

        $properties = $reflector->getDefaultProperties();
        foreach ($properties as $key => $value){
            if(!strpos($jsonString,'"'.$key.'"')){
                $response->addError(new RequestNotValidException(MessageController::getInternalMessage("en",9). $key));
            }
        }


    }
}
