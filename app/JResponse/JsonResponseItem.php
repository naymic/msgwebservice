<?php

namespace App\JResponse;

class JsonResponseItem{
	
	public $idmsg;
	public $type;
	public $msg;
	
	
	
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
	
	public function setMsg($msg){
		$this->msg=$msg;
	}
	
	public function getMsg(){
		return $this->msg;
	}
	
}