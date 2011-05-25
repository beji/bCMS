<?php
/**
 * contains the Log class for logging of events/errors
 * @see Log
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package includes
 */
if(!defined('IN_BCMS')) die;
/**
 * Basic class to handle logging
 * 
 * @todo function to set the logpath
 */
class Log {
        /**
	 * The path to the logfiles
	 * @access private
	 * @var string 
	 */
	var $logpath;
	function Log(){
		if(is_dir("./log/")){
			$this->logpath="./log/";
		}
		elseif(is_dir("../log/")){
			$this->logpath="../log/";
		}
	}
	/**
	 * Function to write something into the debug log
	 * @todo replace this with writeLog()
	 * @param type $file
	 * @param type $line
	 * @param type $msg 
	 */
	function writeDebugLog($file,$line,$msg){
		$handle = fopen($this->logpath."debug.log", "a+t");
		$string = date("m.d.y H:i:s")."URI: ".$_SERVER['REQUEST_URI']." File: ".$file." on line: ".$line.": ".$msg."\n";
		fwrite($handle,$string);
		fclose($handle);
	}
	/**
	 * Function to write something into the error log
	 * @todo replace this with writeLog()
	 * @param type $file
	 * @param type $line
	 * @param type $msg 
	 */
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
	/**
	 * Write something into a logfile
	 * 
	 * This function will be used for a more flexible logging system.
	 * Errortypes can be choosen freely, for every error-type a seperate logfile will be created
	 * @todo write this function...
	 * @param string $file the file the error happened in, should be given with __FILE__
	 * @param integer $line the line inside $file in which the error happened, should be given with __LINE__
	 * @param string $msg your errormessage
	 * @param string $errortype the type of your error (e.g. ERROR, DEBUG)
	 */
	function writeLog($file=null,$line=null,$msg=null,$errortype="error"){
		$handle = fopen($this->logpath.strtolower($errortype).".log", "a+");
		$string = date("m.d.y H:i:s")."URI: ".$_SERVER['REQUEST_URI'];
		if($file!=null) $string.=" File: ".$file;
		if($line!=null) $string.=" on line: ".$line;
		if($msg!=null) $msg.=": ".$msg;
		$string.="\n";
		fwrite($handle,$string);
		fclose($handle);
	}
}
?>