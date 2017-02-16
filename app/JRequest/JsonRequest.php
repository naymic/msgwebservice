<?php

namespace App\JRequest;

class JsonRequest{
	
	private $apptoken;
	private $appid;
	private $modulid;
	private $applang;
	
	private $requitems = array();
	private $requitemsreplace = array();

	

	
	
	### Setters & Getters
	
	public function setAppToken($apptoken){
		$this->apptoken=$apptoken;
	}
	
	public function getAppToken(){
		return $this->apptoken;
	}
	
	public function setAppId($appid){
		$this->appid=$appid;
	}
	
	public function getAppId(){
		return $this->appid;
	}
	
	public function setModulId($modulid){
		$this->modulid=$modulid;
	}
	
	public function getModulId(){
		return $this->modulid;
	}
	
	public function setAppLang($applang){
		strtolower($applang);
		$this->applang=$applang;
	}
	
	public function getAppLang(){
		return $this->applang;
	}
	
	public function setRequItems($requitems){
		$this->requitems =$requitems;
	}

	public function getRequItems(){
		return $this->requitems;
	}

    public function setRequItemsReplace($requitemsreplace){
        $this->requitemsreplace =$requitemsreplace;
    }

    public function getRequItemsReplace(){
        return $this->requitemsreplace;
    }
	
	
	
	
}


?>
