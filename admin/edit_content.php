<?php
/**
 * Page for editing content 
 * 
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package backend
 */
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
		//Get the categories the article is currently in
		$getCurrentCats=mysql_query('SELECT  `'.DB_PREFIX.'categories`.`alias` 
		    FROM  `'.DB_PREFIX.'cat_cont` 
		    LEFT JOIN  `bcms`.`'.DB_PREFIX.'categories` ON  `'.DB_PREFIX.'cat_cont`.`cat_alias` =  `'.DB_PREFIX.'categories`.`alias` 
		    WHERE (
		    `'.DB_PREFIX.'cat_cont`.`cont_id` =1
		    )
		');
		/*This line writes the whole sql result into a array instead of the one array per line you would get per mysql_fetch_array()
		By KingIsulgard - http://php.net/manual/de/function.mysql-fetch-array.php*/
		for($i = 0; $currentCats[$i] = mysql_fetch_assoc($getCurrentCats); $i++);
		array_pop($currentCats); //Last one will always be emtpy so it can be deleted

		//Now build a select-list of all categories with the already connected preselected
		$getAllCategories=mysql_query('SELECT * FROM  `'.DB_PREFIX.'categories` ');
		echo '<select name="categories" size="'.mysql_num_rows($getAllCategories).'">';   
		while ($catList=mysql_fetch_array($getAllCategories)){
		    $selected='';
		    foreach($currentCats as $catToCheck){
			if($catList['alias']==$catToCheck['alias']){
			    $selected='selected';
			}
		    }
		    echo '<option value="'.$catList['alias'].'" '.$selected.'>'.$catList['name'].'</option>';
		}
		echo '</select>';
		echo '</form>';
	}
}
?>