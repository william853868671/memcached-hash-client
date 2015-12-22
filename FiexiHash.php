<?php

 class FiexiHash {
 	private $serverList = array();
 	private $isSorted = FALSE;
 	/***
		处理key值为一个整数，然后映射到期中一台 memcached服务器
		return int
 	*/
 	public function mHash($key){
 		$md5 = substr(md5($key), 0,8);
 		$seed = 31;
 		$hash = 0;
 		for ($i=0; $i < 8; $i++) { 
 			$hash = $hash * $seed + ord($md5{$i});
 			$i++;
 		}
 		return $hash & 0x7FFFFFFF;
 	} 

 	public function addServer($server){
 		$hash = $this->mHash($server);
 		if(!isset($this->serverList[$hash])){
 			$this->serverList[$hash] = $server;
 		}
 		$this->isSorted = FALSE;
 		return TRUE;
 	}

 	public function removeServer($server){
 		$hash = $this->mHash($server);
 		if(isset($this->serverList[$hash])){
 			unset($this->serverList[$hash]);
 		}
 		$this->isSorted = FALSE;
 		return TRUE;
 	}

 	public function lookUp($key){
 		$hash = $this->mHash($key);
 		if(!$this->isSorted){
 			krsort($this->serverList,SORT_NUMERIC);
 			$this->isSorted = TRUE;
 		}
 		var_dump($this->serverList);
 		foreach ($this->serverList as $pos => $server) {
 			if($hash >= $pos) return $server;
 		}

 		return $this->serverList[count($this->serverList)-1];
 	}

 }