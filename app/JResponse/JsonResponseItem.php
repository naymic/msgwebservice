<?php

namespace App\JResponse;

class JsonResponseItem{
	
	public $idmsg;
	public $type;
	public $msg;


    public function replace($msg, $replace = array()){
        $responseItem->setMsg(str_replace("{{". $placeholder ."}}",$replace, $responseItem->getMsg()));
    }

	
	### Setters & Getters ###
	
	public function setIdmsg($idmsg){
		$this->idmsg=$idmsg;
	}
	
	public function getIdmsg(){
		return $this->idmsg;
	}
	
	public function setType($type){
		$this->type=$type;
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function setMsg($msg, $replace = array()){
		if(count($replace) != 0){
		    foreach ($replace as $key => $rpl){
		        $msg = str_replace("{{". $key ."}}", $rpl, $msg);
            }
        }
	    $this->msg=$msg;
	}
	
	public function getMsg(){
		return $this->msg;
	}
	
}