<?php
if(!defined('IN_BCMS')) die;
class Log {
//date("m.d.y H:i:s")." File: ".__FILE__." on line: ".__LINE__.": ".ERRORMSG
	private $logpath;
	function Log(){
		if(is_dir("./log/")){
			$this->logpath="./log/";
		}
		elseif(is_dir("../log/")){
			$this->logpath="../log/";
		}
	}
	function writeDebugLog($file,$line,$msg){
		$handle = fopen($this->logpath."debug.log", "a+t");
		$string = date("m.d.y H:i:s")."URI: ".$_SERVER['REQUEST_URI']." File: ".$file." on line: ".$line.": ".$msg."\n";
		fwrite($handle,$string);
		fclose($handle);
	}	
	function writeErrorLog($file,$line,$msg){
		$handle = fopen($this->logpath."error.log", "a+t");
		$string = date("m.d.y H:i:s")."URI: ".$_SERVER['REQUEST_URI']." File: ".$file." on line: ".$line.": ".$msg."\n";
		fwrite($handle,$string);
		fclose($handle);
	}
	function clearDebugLog(){
		$handle = fopen($this->logpath."debug.log", "w+");
		fclose($handle);
	}
	function clearErrorLog(){
		$handle = fopen($this->logpath."error.log", "w+");
		fclose($handle);
	}
	 
	function writeLog($file=null,$line=null,$msg=null,$errortype="ERROR"){
	   //NOT YET IMPLEMENTED
	}
}
?>