<?php

namespace MessageWebService\Exceptions;

class AppNotFoundException extends MyException{
	
	public function __construct($msg = ''){
		if(strlen($msg) == 0){
			parent::__construct("The app id and token are not combining. Please verify your credendials!", 401);
		}else{
			parent::__construct($msg, 401);
		}
	}
	
}


?>