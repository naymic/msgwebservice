<?php
namespace MessageWebService\Exceptions;
use Exception;


class MyException extends Exception{
	
	private $msg;
	private $httpErrorCode;
	
	
	public function  __construct($msg, $httpErrorCode){
		parent::__construct($msg);
		$this->setHttpErrorCode($httpErrorCode);
		http_response_code($httpErrorCode);
	}
	
	
	
	### Getters & Setter ###
	public function setMsg($msg){
		$this->msg=$msg;
	}
	
	public function getMsg(){
		return $this->msg;
	}
	
	public function setHttpErrorCode($httpErrorCode){
		$this->httpErrorCode=$httpErrorCode;
	}
	
	public function getHttpErrorCode(){
		return $this->httpErrorCode;
	}
}



?>