<?php
if(!defined('IN_BCMS')) die;
if (file_exists("./inc/sqldata.php")) {$sqlpath="./inc/sqldata.php";}
elseif (file_exists("../inc/sqldata.php")) {$sqlpath="../inc/sqldata.php";}
elseif (file_exists("./sqldata.php")) {$sqlpath="./sqldata.php";}

include $sqlpath;

/*Class to get/set Values in the config-Table
*/
class Config {

	
	function Config(){
		
	}
	/*Function to Add/Change values inside the config Table
	$key = The variable to change
	$value = The value of that variable (stored as VARCHAR)
	$description = Optional description of the key variable*/
	function SetValue($key, $value, $description = 0) {
		//Try to update an existing value first
		if($description!=0) {
			$sql="UPDATE  `".DB_PREFIX."config` SET  `value` =  '".$value."',`description` = '".$description."'  WHERE `key` =  '".$key."'";
		}
		else {
			$sql="UPDATE  `".DB_PREFIX."config` SET  `value` =  '".$value."' WHERE `key` =  '".$key."'";
		}
		$query=mysql_query($sql);
		if (mysql_affected_rows()==0) {
			//Updating failed, lets try to insert a new value
			$query=mysql_query("
				INSERT INTO  `".MYSQL_DATABASE."`.`".DB_PREFIX."config` (
					`key` ,
					`value` ,
					`description`
					)
					VALUES (
					'".$key."',  '".$value."',  '".$description."'
					);
					");
			if(mysql_affected_rows()==0){
				if (file_exists("./inc/log.php")) {$logpath="./inc/log.php";}
				elseif (file_exists("../inc/log.php")) {$logpath="../inc/log.php";}
				include_once $logpath;
				$log = new Log();
				$log->writeErrorLog(__FILE__,__LINE__,"could not insert/update Key $key , value $value config! ".mysql_error());
			}
		}
	}
	//Returns the value $value of the given variable $key
	function GetValue($key){
		$query=mysql_query("SELECT `value` FROM `".DB_PREFIX."config` WHERE `key` = '".$key."'");
		if(!$query){
			die("Invalid SQL Request! "  . mysql_error());
		}
		if(mysql_num_rows($query)==0){
			if (file_exists("./inc/log.php")) {$logpath="./inc/log.php";}
			elseif (file_exists("../inc/log.php")) {$logpath="../inc/log.php";}
			include_once $logpath;
			$log = new Log();
			$log->writeDebugLog(__FILE__,__LINE__,"Variable $key not set in config Table");
			return false;
		}
		else{
			$value=mysql_fetch_array($query);
			return $value['value'];
		}
	}
}
?>