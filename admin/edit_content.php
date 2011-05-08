<?php
define('IN_BCMS',true);
include_once "../inc/config.php";
include_once "../inc/loc.php";
if(!isset($loc) && !is_object($loc)){
	$loc = new Loc();
}
if(!isset($_GET['aid'])){
	if (file_exists("./inc/log.php")) {$logpath="./inc/log.php";}
	elseif (file_exists("../inc/log.php")) {$logpath="../inc/log.php";}
	include_once $logpath;
	$log = new Log();
	$log->writeErrorLog(__FILE__,__LINE__,"id not found.");
}
else{

	if(!is_numeric($_GET['aid'])){
		if (file_exists("./inc/log.php")) {$logpath="./inc/log.php";}
		elseif (file_exists("../inc/log.php")) {$logpath="../inc/log.php";}
		include_once $logpath;
		$log = new Log();
		$log->writeErrorLog(__FILE__,__LINE__,"id ".$_GET['aid']." not an integer.");
	}
	else{
		$getcontent=mysql_query("
			SELECT `".DB_PREFIX."content`.* FROM `".DB_PREFIX."content` WHERE (`".DB_PREFIX."content`.`id` =\"".$_GET['aid']."\")");
		if(mysql_num_rows($getcontent)>0){
			$art=mysql_fetch_array($getcontent);
			echo "<form method=\"post\" name=\"formular\" action=\"index.php?id=add_content\">\n
			<label for=\"title\">".$loc->getLocString("TITLE")."</label>
			<input name=\"title\" type=\"text\" value=\"".$art['title']."\"><br>
			<label for=\"title\">".$loc->getLocString("DATE")."</label>
			<input name=\"date\" type=\"text\" value=\"".$art['date']."\"><br>
			<textarea id=\"cont\" class=\"mce\" name=\"content\" cols=\"50\" rows=\"15\">".$art['content']."</textarea>";
		}
		else{
			"NOT YET IMPLEMENTED";
		}
	}
}
?>