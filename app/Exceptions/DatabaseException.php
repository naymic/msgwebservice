<?php

namespace App\Exceptions;

class DatabaseException extends MyException{
	
	public function __construct($msg){
		parent::__construct($msg, 500);
	}
	
	
}


?>