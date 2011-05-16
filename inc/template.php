<?php
/**
 * contains the Template class
 * @see Template
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package includes
 */
if(!defined('IN_BCMS')) die;
/**
 * The class used to render the page using a template
 */
class Template{
        /**
	 * The path to the main template file
	 * @access private
	 * @var string 
	 */
	var $maintemplate=false;
        /**
	 * The path to the article template file
	 * @access private
	 * @var string 
	 */
	var $articletemplate=false;
        /**
	 * The finished template string
	 * 
	 * This string contains the finished html code of the page
	 * @access private
	 * @var string 
	 */
	var $template=false;
	/**
	 * sets the template path
	 * @see $maintemplate
	 * @see $articletemplate
	 * @param string $template the foldername of the template inside the /template folder
	 */
	function setTemplate($template=false){
		if($template===false){
			require_once "inc/config.php";
			$config = new Config();
			$template = $config->GetValue("TEMPLATE");
		}
		if(file_exists("./template/".$template."/template.html")){
			$this->maintemplate="./template/".$template."/template.html";
			$this->articletemplate="./template/".$template."/article.html";		
		}
		elseif(file_exists("../template/".$template."/template.html")){
			$this->maintemplate="../template/".$template."/template.html";
			$this->articletemplate="../template/".$template."/article.html";		
		}
		else{
			if (file_exists("./inc/log.php")) {$logpath="./inc/log.php";}
			elseif (file_exists("../inc/log.php")) {$logpath="../inc/log.php";}
			include_once $logpath;
			$log = new Log();
			$log->writeErrorLog(__FILE__,__LINE__,"Template $template not found!");
		}
	}
	/**
	 * Assigns/replaces the template vars
	 * 
	 * This function replaces the placeholders of the template with the values given
	 * @param array $vars the array containing the replacement-functions
	 * @example index.php Near the end of index.php
	 */
	function assignVars($vars){
		if($this->maintemplate===false || $this->articletemplate===false){
			$this->setTemplate();
		}
		if(file_exists($this->maintemplate)){
			$this->template = file_get_contents($this->maintemplate);
		}
		foreach($vars as $key=>$element){
			while(strpos($this->template,"{".$key."}")!==false){
				$this->template=str_replace("{".$key."}",$element,$this->template);
			}
		}
	}
	/**
	 * Returns the finished page
	 * 
	 * Returns the finished html code of the page inside a string
	 * Should only be called after the templatepaths are set and the placeholders are replaced with actual content
	 * @return type the finished html code of the page
	 */
	function getFinalSite(){
		return $this->template;
	}
	/**
	 * Returns the html code of the article template
	 * @return string the html code of the article template
	 */
	function getArticleTemplate(){
		$tpl=false;
		if($this->articletemplate===false){
			$this->setTemplate();
		}
		if(file_exists($this->articletemplate)){
			$tpl=file_get_contents($this->articletemplate);
		}
		return $tpl;
	}
}
?>