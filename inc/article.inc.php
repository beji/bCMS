<?php
if(!defined('IN_BCMS')) die;
/*Basic class that gets an article (set by $id) from the contents table*/
class Article{
	private $id=false;
	
	function Article($id=false){
		if($id!==false)$this->SetArtno($id);
	}
	function SetArtno($id){
		$this->id=$id;
	}
	/*Gets the article from the db, generates the html code with the template and returns the code as a string*/
	function GetArticle() {
		if($this->id===false){
			include_once "./inc/log.php";
			$log = new Log();
			$log->writeErrorLog(__FILE__,__LINE__,"Article id not set!");
			return false;
		}
		require_once "./inc/db2date.php";
		require_once "./inc/template.php";
		$config =  new Config();
		$query=mysql_query("SELECT * FROM ".DB_PREFIX."content WHERE id='".$this->id."'");
		$datensatz=mysql_fetch_array($query);
		$article="";
		$template = new Template();
		$article=$template->getArticleTemplate();
		if(strpos($article,"{ID}")) $article=str_replace("{ID}",$datensatz['id'],$article);
		if(strpos($article,"{TITLE}")) $article=str_replace("{TITLE}",$datensatz['title'],$article);
		if(strpos($article,"{DATE}")) $article=str_replace("{DATE}",db2date($datensatz['date']),$article);
		if(strpos($article,"{CONTENT}")) $article=str_replace("{CONTENT}",$datensatz['content'],$article);
		return $article;
	}
}
?>