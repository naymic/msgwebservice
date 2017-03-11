<?php

namespace MessageWebService\JResponse;
use MessageWebService\Exceptions\MyException;
use MessageWebService\JResponse\JsonResponseItem;

class JSonResponse{
	
	public $success;
	public $responseItems = array();
    public $infoMessages = array();
	public $errorMsgs = array();
	public $htmlErrorCodes = array();
	
	public function __construct(){
		$this->setSuccess(true);
	}
	

	public function addInfoMessage($message){
		$this->infoMessages[] = $message;
	}
	
	public function addError(MyException $error){
		$this->setSuccess(false);
		$this->errorMsgs[] = $error->getMessage();
		$this->htmlErrorCodes[] = $error->getHttpErrorCode();
	}
	

	public function addResponseItem(JsonResponseItem $item){
		$this->responseItems[] = $item;
	}

	### Setter && Getters ###
	public function setSuccess($success){
		$this->success = $success;
	}
	
	public function getSuccess(){
		return $this->success;
	}
	
	public function setResponseItems($responseItems){
		$this->responseItems = $responseItems;
	}
	
	public function getResponseItems(){
		return $this->responseItems;
	}

	public function setInfoMessages($infoMessages){
		$this->infoMessages =$infoMessages;
	}

	public function getInfoMessages(){
		return $this->infoMessages;
	}
	
	public function setErrors( $errors){
		$this->errorMsgs = $errors;
	}
	
	public function getErrors(){
		return $this->errorMsgs;
	}
	
	public function setHtmlErrorCodes( $htmlErrorCodes){
		$this->htmlErrorCodes = $htmlErrorCodes;
	}
	
	public function getHtmlErrorCodes(){
		return $this->htmlErrorCodes;
	}
	
}


?> 