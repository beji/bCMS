<?php
/**
 * contains the Loc class for the localization
 * @see Loc
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package includes
 */
if(!defined('IN_BCMS')) die;
if (file_exists("./inc/config.php")) {$sqlpath="./inc/config.php";}
elseif (file_exists("../inc/config.php")) {$sqlpath="../inc/config.php";}
include_once $sqlpath;

/**
 * The Localization class
 * 
 * Maybe I should turn this into a function?
 */
class Loc{
    /**
     * The (currently) only function of the class
     * 
     * This function tries to get a localized string for a placeholder depending on the default language in the db
     * If the default language contains no translation for the placeholder it checks the enEN language file.
     * If nothing is found there it writes an Error
     * @see Log
     * @param string $placeHolder the placeholder used inside the php code
     * @param string $lang the language that should be checked first. if none is set it chooses the default language
     * @return string the localized string, returns "" if nothing was found
     */
    function getLocString($placeHolder, $lang=0){
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

	if($loc[$placeHolder]==NULL){
	    if (file_exists("./lang/msg_enEN.php")) {$lngpath="./lang/msg_enEN.php";}
	    elseif (file_exists("../lang/msg_enEN.php")) {$lngpath="../lang/msg_enEN.php";}
	    include_once $lngpath;
	    if($loc[$placeHolder]==NULL){
		if (file_exists("./inc/log.php")) {$logpath="./inc/log.php";}
		elseif (file_exists("../inc/log.php")) {$logpath="../inc/log.php";}
		include_once $logpath;
		$log = new Log();
		$log->writeErrorLog(__FILE__,__LINE__,"Key $placeHolder was not found in $lang or enEN logfile.");
		$ret="";
	    }
	    else{
		$ret=$loc[$placeHolder];
	    }
	}
	else{
	    $ret=$loc[$placeHolder];
	}
	return $ret;
    }
}
?>