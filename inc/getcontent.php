<?php
if(!defined('IN_BCMS')) die;
require_once "./inc/config.php";

function getArticlesInCategory($id,$offset) {
	require_once "./inc/db2date.php";
	require_once "./inc/article.inc.php";
	$config =  new Config();
	$query=mysql_query(
	"SELECT  `".DB_PREFIX."content`.`id`
	FROM  `".DB_PREFIX."categories` 
	LEFT JOIN  `fbcms`.`".DB_PREFIX."cat_cont` ON  `".DB_PREFIX."categories`.`alias` =  `".DB_PREFIX."cat_cont`.`cat_alias` 
	LEFT JOIN  `fbcms`.`".DB_PREFIX."content` ON  `".DB_PREFIX."cat_cont`.`cont_id` =  `".DB_PREFIX."content`.`id` 
	WHERE (
		`".DB_PREFIX."categories`.`alias` =  '".$id."'
	)
	ORDER BY `".DB_PREFIX."content`.`id` DESC
	LIMIT ".$offset.",".$config->GetValue("ARTICLES_PER_PAGE")."
	");
	$content="";
	while ($datensatz=mysql_fetch_array($query)){
			$article = new Article($datensatz['id']);
			$content=$content.$article->GetArticle();
	}
	return $content;
}
function gettitle($id){
	$query=mysql_query("SELECT alias,name FROM ".DB_PREFIX."categories");
	$title=" - ";
	while($datensatz=mysql_fetch_array($query)){
		if($datensatz['alias']==$id) $title=$title.$datensatz['name'];
	}
	return $title;
}

function createnav($id) {
	global $id;
	$str="<ul id=\"nav\">\n";
	$query=mysql_query("SELECT * FROM ".DB_PREFIX."categories ORDER BY pos ASC");
	while($datensatz=mysql_fetch_array($query)){
		$class="";
		if($datensatz['alias']==$id){
			$class="class=\"current\"";
		}
		$str=$str."<li><a href=\"".$datensatz['link']."\"".$class.">".$datensatz['name']."</a></li>\n";
	}
	$str=$str."</ul>\n";
	return $str;
}
?>