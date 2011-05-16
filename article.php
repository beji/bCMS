<?php
/**
 * Main file for displaying the articles
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package main_files
 */
/**
 * This define is used for a simple lockout
 * 
 * Every include has a check if this definition is set
 */
define('IN_BCMS',true);
require "inc/config.php";

$config = new Config();

//if we have no id, we are on the news page
$artno = isset($_GET['artno']) ? $_GET['artno'] : 0;
//if Caching is enabled, check for existing Cachefile
if($config->GetValue("CACHING")) {
	include "inc/cache.php";
	$cache = new Cache();
	$cache->Initialize($artno,"article");
	//returns Content of cachefile if exists, 0 otherwise
	$content=$cache->CheckforFile();
}
//If caching is disabled or no cachefile exists, the page has to be generated
if(!$config->GetValue("CACHING") || !$content){
	include "./inc/template.php";
	include "./inc/getcontent.php";
	require "inc/article.inc.php";
	$article = new Article($artno);
	$template = new Template();
	
	$template->assignVars($arr=array(
				'CONT'			=>	$article->GetArticle(),
				'TITLE'			=>	$config->GetValue("TITLE").getTitle($artno),
				'HEAD_TITLE'	=>	'<a href="index.php">'.$config->GetValue("HEAD_TITLE").'</a>',
				'NAV'			=>	createnav($artno),
				'PAGES'			=>	""	//No need for multiple pages. Leaves an empty Container but who cares...
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