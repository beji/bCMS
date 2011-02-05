<?php
if(!defined('IN_BCMS')) die;
class Template{
	private $maintemplate=false;
	private $articletemplate=false;
	private $template=false;
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
	function getFinalSite(){
		return $this->template;
	}
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