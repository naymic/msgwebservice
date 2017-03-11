<?php

namespace MessageWebService\JResponse;

class JsonResponseItem{
	
	public $idmsg;
	public $type;
	public $message;

	
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
		        $msg = str_replace("[[". $key ."]]", $rpl, $msg);
            }
        }
	    $this->message=$msg;
	}
	
	public function getMsg(){
		return $this->message;
	}
	
}