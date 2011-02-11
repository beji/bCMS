<?php
if(!defined('IN_BCMS')) die;
if (file_exists("./inc/config.php")) {$sqlpath="./inc/config.php";}
elseif (file_exists("../inc/config.php")) {$sqlpath="../inc/config.php";}
include_once $sqlpath;
class Loc{
	function getLocString($string, $lang=0){
		$config = new Config;
		if($lang===0){
			$lang = $config->GetValue("DEFAULT_LANG");
			if($lang===false){
				$config->SetValue("DEFAULT_LANG","enEN","The default language");
				$lang="enEN";
			}
		}
		else{
			if (!file_exists("./lang/msg_".$lang.".php") && !file_exists("../lang/msg_".$lang.".php")){
				if (file_exists("./inc/log.php")) {$logpath="./inc/log.php";}
				elseif (file_exists("../inc/log.php")) {$logpath="../inc/log.php";}
				include_once $logpath;
				$log = new Log();
				$log->writeDebugLog(__FILE__,__LINE__,$lang."-Logfile could not be found, switching to enEN.");
				$lang="enEN";
			}
		}
		$lngpath="";
		if (file_exists("./lang/msg_".$lang.".php")) {$lngpath="./lang/msg_".$lang.".php";}
		elseif (file_exists("../lang/msg_".$lang.".php")) {$lngpath="../lang/msg_".$lang.".php";}
		
		include $lngpath;
		
		if($loc[$string]==NULL){
			if (file_exists("./lang/msg_enEN.php")) {$lngpath="./lang/msg_enEN.php";}
			elseif (file_exists("../lang/msg_enEN.php")) {$lngpath="../lang/msg_enEN.php";}
			include_once $lngpath;
			if($loc[$string]==NULL){
				if (file_exists("./inc/log.php")) {$logpath="./inc/log.php";}
				elseif (file_exists("../inc/log.php")) {$logpath="../inc/log.php";}
				include_once $logpath;
				$log = new Log();
				$log->writeErrorLog(__FILE__,__LINE__,"Key $string was not found in $lang or enEN logfile.");
				$ret="";
			}
			else{
				$ret=$loc[$string];
			}
		}
		else{
			$ret=$loc[$string];
		}
		return $ret;
	}
}
?>