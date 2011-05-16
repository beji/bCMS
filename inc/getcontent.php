<?php
/**
 * Functions for content generation
 * 
 * This file contains the functions used to get the fitting content for the current page
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package includes
 */
if(!defined('IN_BCMS')) die;
require_once "./inc/config.php";
/**
 * get all articles that should be displayed
 * @see Article
 * @param string $alias the alias of the category that you want the articles for 
 * @param int $offset number of the article to start (e.g 5 -> 5. article)
 * @return string a string containing the html code for all the articles
 */
function getArticlesInCategory($alias,$offset) {
	require_once "./inc/db2date.php";
	require_once "./inc/article.inc.php";
	$config =  new Config();
	$query=mysql_query(
	"SELECT  `".DB_PREFIX."content`.`id`
	FROM  `".DB_PREFIX."categories` 
	LEFT JOIN  `".MYSQL_DATABASE."`.`".DB_PREFIX."cat_cont` ON  `".DB_PREFIX."categories`.`alias` =  `".DB_PREFIX."cat_cont`.`cat_alias` 
	LEFT JOIN  `".MYSQL_DATABASE."`.`".DB_PREFIX."content` ON  `".DB_PREFIX."cat_cont`.`cont_id` =  `".DB_PREFIX."content`.`id` 
	WHERE (
		`".DB_PREFIX."categories`.`alias` =  '".$alias."'
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
/**
 * generates affix for page title
 * this function is used to display the current category in the page title displayed in the browser.
 * @todo fix this for articles
 * @param int $alias the alias of the category
 * @return string returns the affix in the style of " - {categoryName}"
 */
function getTitle($alias){
	$query=mysql_query("SELECT alias,name FROM ".DB_PREFIX."categories");
	$title=" - ";
	while($datensatz=mysql_fetch_array($query)){
		if($datensatz['alias']==$alias) $title=$title.$datensatz['name'];
	}
	return $title;
}
/**
 * Creates the page Navigation
 * @param string $alias the alias of the current category
 * @return string the html code of the navigation
 */
function createnav($alias) {
	$str="<ul id=\"nav\">\n";
	$query=mysql_query("SELECT * FROM ".DB_PREFIX."categories ORDER BY pos ASC");
	while($datensatz=mysql_fetch_array($query)){
		$class="";
		if($datensatz['alias']==$alias){
			$class="class=\"current\"";
		}
		$str=$str."<li><a href=\"".$datensatz['link']."\"".$class.">".$datensatz['name']."</a></li>\n";
	}
	$str=$str."</ul>\n";
	return $str;
}
?>