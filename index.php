<?php
define('IN_BCMS',true);
require "./inc/config.php";
$config = new Config();
//if we have no id, we are on the news page
$id = isset($_GET['id']) ? $_GET['id'] : "news";
//if Caching is enabled, check for existing Cachefile
if($config->GetValue("CACHING")) {
	include "inc/cache.php";
	$cache = new Cache();
	$cache->Initialize($id,"index");
	//returns Content of cachefile if exists, 0 otherwise
	$content=$cache->CheckforFile();
}
//If caching is disabled or no cachefile exists, the page has to be generated
if(!$config->GetValue("CACHING") || !$content){
	include "./inc/template.php";
	include "./inc/getcontent.php";
	$template = new Template();

	//Since we don't want an endlessly huge page we split the content on pages now
	
	//If page is not set, we are on page 1
	$currentpage  = isset($_GET['page'])?(int)$_GET['page']:1;
	
	$query=mysql_query(
	"SELECT  `".DB_PREFIX."content`.`id`
	FROM  `".DB_PREFIX."categories` 
	LEFT JOIN  `".MYSQL_DATABASE."`.`".DB_PREFIX."cat_cont` ON  `".DB_PREFIX."categories`.`alias` =  `".DB_PREFIX."cat_cont`.`cat_alias` 
	LEFT JOIN  `".MYSQL_DATABASE."`.`".DB_PREFIX."content` ON  `".DB_PREFIX."cat_cont`.`cont_id` =  `".DB_PREFIX."content`.`id` 
	WHERE (
		`".DB_PREFIX."categories`.`alias` =  '".$id."'
	)
	ORDER BY `".DB_PREFIX."content`.`id` DESC");
	//All of that SQL stuff only to check how many articles we actually have in that category...
	$no_of_articles = mysql_num_rows($query);
	
	//Gives us the number of pages we need
	$num_pages = ceil($no_of_articles/$config->GetValue("ARTICLES_PER_PAGE"));
	
	//Just in case it should be 0 or worse ;)
    if(!$num_pages) {
        $num_pages = 1;
    }
	//This creates the Links to change pages if we need more than one
	 $pages ="";
	 if($num_pages>1){
		$pages="Seiten:<br>";
		for($i=1;$i<=$num_pages;$i++){
			if($i==$currentpage){	//current page needs no link, we are already there ;)
				$pages=$pages." $i ";
			}
			else{
				$linkid=isset($_GET['id']) ? "id=".$_GET['id']."&" : "";
				$pages=$pages." <a href=\"index.php?".$linkid."page=$i\">$i</a> ";
			}
		}
	 }
	$template->assignVars($arr=array(
				'CONT'			=>	getArticlesInCategory($id,($currentpage - 1) * $config->GetValue("ARTICLES_PER_PAGE")),
				'TITLE'			=>	$config->GetValue("TITLE").gettitle($id),
				'HEAD_TITLE'	=>	$config->GetValue("HEAD_TITLE"),
				'NAV'			=>	createnav($id),
				'PAGES'			=>	$pages
				));
				
	$content=$template->getFinalSite();
}
//everything should be done, lets use the html code generated inside $content
echo $content;
//if caching is enabled and there is no cachefile, we should propably build one if possible
if($config->GetValue("CACHING") && !$cache->fileexists()) {
	$cache->CreateCacheFile($content);
}
?>