<?php
namespace MessageWebService\Exceptions;
use MessageWebService\Exceptions\MyException;

class RequestNotValidException extends MyException{
	
	public function __construct($msg){
		parent::__construct($msg, 400);
	}
	
	
}


?>