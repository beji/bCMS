<?php
/**
 * Sets up db connection & Config class
 * @see Config
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package includes
 */
if(!defined('IN_BCMS')) die;
if (file_exists("./inc/sqldata.php")) {$sqlpath="./inc/sqldata.php";}
elseif (file_exists("../inc/sqldata.php")) {$sqlpath="../inc/sqldata.php";}
elseif (file_exists("./sqldata.php")) {$sqlpath="./sqldata.php";}

include $sqlpath;

/**
 * Class to set/get config data
 * 
 * The CMS uses a central config table inside the database to store general values inside.
 * This class is used to easily get/set these values
 */
class Config {
	/**
	 * Sets/inserts a key/value in the db
	 * 
	 * This function tries to update a key inside the config db. 
	 * 
	 * If the key does not exist it tries to insert the key into the config db.
	 * 
	 * @param string $key the key to be set/inserted
	 * @param string $value the value of the key
	 * @param string $description optional description for the key
	 */
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
	/**
	 * Returns the value for a $key
	 * @param string $key the value of this key should be returned
	 * @return bool|string returns false if the key is not in the config db or the value of the key as a string 
	 */
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