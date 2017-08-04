<?php
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 11.03.17
 * Time: 10:10
 */

namespace MessageWebService\Exceptions;
use MessageWebService\Exceptions\MyException;

class EmptyRequestException extends MyException{

    public function __construct($msg){
        parent::__construct($msg, 400);
    }


}


?>