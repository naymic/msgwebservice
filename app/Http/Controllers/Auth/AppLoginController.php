<?php

namespace MessageWebService\Http\Controllers\Auth;

use MessageWebService\Application;
use MessageWebService\Exceptions\AppNotFoundException;
use MessageWebService\Exceptions\RequestNotValidException;
use MessageWebService\Exceptions\AutenticationException;
use MessageWebService\Http\Controllers\MessageController;
use MessageWebService\JsonRequest\JsonRequest;
use MessageWebService\JsonResponse\JsonResponse;

class AppLoginController{
	
	private $id;
	private $token;
	private $isLogged;
	
	private static $ic = null;
	
	public static function getInstance(){
		if(self::$ic == null){
            self::$ic = new AppLoginController();
		}
		return self::$ic ;
	}
	
	private function __construct(){
		
	}

	public function identify(JsonResponse &$response, JsonRequest $request) {

        try{
            if ( strlen ( $request->getAppToken()) == 0) {
                throw new RequestNotValidException(MessageController::getInternalMessage($request->getAppLang(), 6));
            }

            $apps = Application::where('id', $request->getAppId())->first();

            if(empty($apps)){
                throw new AppNotFoundException(MessageController::getInternalMessage($request->getAppLang(), 1));
            }

            $givenHash = crypt($request->getAppToken(), $apps->token);
            if($givenHash != $apps->token){
                throw new AutenticationException($request->getAppLang());
            }

            $this->setId($request->getAppId());
            $this->setToken($givenHash);
            $this->setLogged(true);

        }catch (AutenticationException $ae){
            $response->addError($ae);
        }
    }

	
	
	### Setters && getters ###
	
	public function  setLogged($logged){
		$this->isLogged = $logged;
	}
	
	public function isLogged(){
		return $this->isLogged;
	}
	
	public function setToken($token){
		$this->token=$token;
	}
	
	public function getToken(){
		return $this->token;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	
	
	
	
}


?>