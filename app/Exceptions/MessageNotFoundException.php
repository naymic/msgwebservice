<?php
namespace App\Exceptions;

class MessageNotFoundException extends MyException{

    private $messageId;

	public function __construct($msg = "", $messageId = -1)
    {
        if(strlen($msg) != 0 ){
            parent::__construct($msg , 400);
        }else if ($messageId != -1) {
            parent::__construct("Please verify your message ID: " . $messageId . ". It could not be found!", 400);
        } else {
            parent::__construct("Please verify your message ID's, not all messages could be found!", 400);
        }
    }





}

?>