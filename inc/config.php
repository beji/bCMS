<?php
if(!defined('IN_BCMS')) die;
if (file_exists("./inc/sqldata.php")) {$sqlpath="./inc/sqldata.php";}
elseif (file_exists("../inc/sqldata.php")) {$sqlpath="../inc/sqldata.php";}
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
			$query=mysql_query("UPDATE  `".DB_PREFIX."config` SET  `value` =  '".$value."',`description` = '".$description."'  WHERE `key` =  '".$key."'");
		}
		else {
			$query=mysql_query("UPDATE  `".DB_PREFIX."config` SET  `value` =  '".$value."' WHERE `key` =  '".$key."'");
		}
		if (!$query) {
			//Updating failed, lets try to insert a new value
			$query=mysql_query("INSERT INTO (`key`, `value`,`description`) VALUES ('".$key."', '".$value."', '".$description."');");
			if(!$query){
				die("Invalid SQL Request, could not insert/update config! "  . mysql_error());
			}
		}
	}
	//Returns the value $value of the given variable $key
	function GetValue($key){
		$query=mysql_query("SELECT `value` FROM `".DB_PREFIX."config` WHERE `key` = '".$key."'");
		$value=mysql_fetch_array($query);
			if(!$query){
				die("Invalid SQL Request! "  . mysql_error());
			}
			else return $value['value'];
	}
}
?>