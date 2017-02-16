<?php
namespace App\Exceptions;

class RequestNotValidException extends MyException{
	
	public function __construct($msg){
		parent::__construct($msg, 400);
	}
	
	
}


?>