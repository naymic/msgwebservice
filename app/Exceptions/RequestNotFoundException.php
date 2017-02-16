<?php
namespace App\Exceptions;

class RequestNotFoundException extends MyException{
	
	public function __construct(){
		parent::__construct("No request was found!", 400);
	}
	
}


?>