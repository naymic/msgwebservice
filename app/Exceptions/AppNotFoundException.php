<?php

namespace MessageWebService\Exceptions;

class AppNotFoundException extends MyException{
	
	public function __construct($msg = ''){
		if(strlen($msg) == 0){
			parent::__construct("The app id don't exist!", 401);
		}else{
			parent::__construct($msg, 401);
		}
	}
	
}


?>