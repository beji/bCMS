<?php
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
		$string = date("m.d.y H:i:s")." File: ".$file." on line: ".$line.": ".$msg."\n";
		fwrite($handle,$string);
		fclose($handle);
	}	
	function writeErrorLog($file,$line,$msg){
		$handle = fopen($this->logpath."error.log", "a+t");
		$string = date("m.d.y H:i:s")." File: ".$file." on line: ".$line.": ".$msg."\n";
		fwrite($handle,$string);
		fclose($handle);
	}
	function clearDebugLog(){
	}
	function clearErrorLog(){
	}
}
?>