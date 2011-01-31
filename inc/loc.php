<?php
if(!defined('IN_BCMS')) die;
if (file_exists("./inc/config.php")) {$sqlpath="./inc/config.php";}
elseif (file_exists("../inc/config.php")) {$sqlpath="../inc/config.php";}
include_once $sqlpath;
class Loc{
	function getLocString($string, $lang=0){
		$config = new Config;
		if($lang==0){
			$lang = $config->GetValue("DEFAULT_LANG");
			if($lang===false){
				echo "BLA";
				$config->SetValue("DEFAULT_LANG","enEN","The default language");
				$lang="enEN";
			}
			echo $lang;
		}
		else{
			echo "BLABLUBB";
			if (!file_exists("./lang/msg_".$lang.".php") && !file_exists("../lang/msg_".$lang.".php")){
				$lang="enEN";
			}
		}
		$lngpath="";
		if (file_exists("./lang/msg_".$lang.".php")) {$lngpath="./lang/msg_".$lang.".php";}
		elseif (file_exists("../lang/msg_".$lang.".php")) {$lngpath="../lang/msg_".$lang.".php";}
		
		include_once $lngpath;
		//include_once "./lang/msg_".$lang.".php";
		
		if($loc[$string]==NULL){
			if (file_exists("./lang/msg_enEN.php")) {$lngpath="./lang/msg_enEN.php";}
			elseif (file_exists("../lang/msg_enEN.php")) {$lngpath="../lang/msg_enEN.php";}
			include_once $lngpath;
			if($loc[$string]==NULL){
				$ret="STRING $string NOT FOUND";
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