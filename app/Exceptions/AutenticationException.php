<?php

namespace MessageWebService\Exceptions;
use MessageWebService\Http\Controllers\MessageController;

class AutenticationException extends MyException{
	
	public function __construct($lang = 3){
		parent::__construct(MessageController::getInternalMessage($lang, 7), 401);
	}
}


?>