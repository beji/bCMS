<?php
if(!defined('IN_BCMS')) die;
//Class to handle the basic caching
class Cache{
	private $siteid;
	private $type;
	private $cachefolder="./cache/";
	private $nocachefolder="./nocache/";
	private $namepattern="cached-{TYPE}-{NAME}.html";
	private $cachefile=0;
	private $fileexists=0;
	
	function Cache() {}
	/*Basic function to set up the caching, needs to be done first
	$id = alias of current category
	$type = needed for naming the cache-file to have a difference between category alias "3" and article nr. 3
			currently used:
				index: category page
				article: detailview of article*/
	function Initialize($id,$type){
		$this->siteid = $id;
		$this->type = $type;
	}
	
	/*Checks if the cachefile already exists
	If file exists and is readable it returns the contents of the file as a string and sets $fileexists to 1
	else it will return 0*/
	function CheckforFile() {
		if(!$this->cachefile) {
			$this->CreateFilePath();
		}
		if(file_exists($this->cachefile)) {
			$file_handle = fopen($this->cachefile,"r");
			if($file_handle) {
				$this->fileexists=1;
				return fread($file_handle,filesize($this->cachefile));
				fclose($file_handle);
			}
		}
		else return 0;
	}
	/*Sets up the Filepath for later use*/
	private function CreateFilePath(){
		$this->cachefile = str_replace("{TYPE}",$this->type,$this->namepattern);
		$this->cachefile = str_replace("{NAME}",$this->siteid,$this->cachefile);
		$this->cachefile = $this->cachefolder.$this->cachefile;
	}
	
	/*Checks if there is a *.nocache file in the nocache Folder.
	If none is found, the cachefile will be created
	$content = the created string containing the html code for the cachefile*/
	function CreateCacheFile($content) {
		if($this->cachefile && !file_exists($this->nocachefolder.$this->siteid.".nocache")) {
			$file_handle = fopen($this->cachefile,"w+");
			if($file_handle){
				fwrite($file_handle,$content);
				fclose($file_handle);
			}
		}
	}
	//returns the value for $fileexists
	function fileexists(){
		return $this->fileexists;
	}
	//Basic function to clear the cachefolder
	function clearcache(){
		$handle = opendir($this->cachefolder);
		while (false !== ($file = readdir($handle))) {
        if($file!="." && $file!="..") unlink ($this->cachefolder.$file);
		}
    }
		
}
?>