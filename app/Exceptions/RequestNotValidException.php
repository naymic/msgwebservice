<?php
namespace MessageWebService\Exceptions;

class RequestNotValidException extends MyException{
	
	public function __construct($msg){
		parent::__construct($msg, 400);
	}
	
	
}


?>