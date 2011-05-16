<?php
/**
 * File that includes the Article class
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package includes
 */

if(!defined('IN_BCMS')) die;
/**
 * Main class to get the content from the database
 * 
 * This class is used in a loop to get an article from the database and store the html layout inside a string
 */
class Article{
	/**
	 * @access private
	 * @var integer $id the id of the article 
	 */
	var $id=false;
	/**
	 * Constructor of the class
	 * @param integer $id sets the {@link $id} of the article
	 */
	function Article($id=false){
		if(($id!==false) && is_numeric($id))$this->SetArtno($id);
	}
	/**
	 * Sets the {@link $id} if it is numeric 
	 * @param integer $id the {@link $id} to be set
	 */
	function SetArtno($id){
		if(is_numeric($id))$this->id=$id;
	}
	/**
	 * Main function of the class
	 * 
	 * Tries to get the content of the article from the database and 
	 * prepares the html code with the article template
	 * @see Template
	 * @return string the string including the articles html code
	 */
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