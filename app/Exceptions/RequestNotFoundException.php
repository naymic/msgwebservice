<?php
namespace MessageWebService\Exceptions;

class RequestNotFoundException extends MyException{
	
	public function __construct(){
		parent::__construct("No request was found!", 400);
	}
	
}


?>