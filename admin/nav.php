<?php
		if(!defined('IN_BCMS')) die;
		include_once "../inc/loc.php";
		if(!isset($loc) && !is_object($loc)){
			$loc = new Loc();
		}
		echo "<ul>";
		echo "<li><a href=\"index.php?id=add_content\">".$loc->getLocString("A_NAV_ADD_ARTICLE")."</a></li>";
		echo "<li><a href=\"index.php?id=list_articles\">".$loc->getLocString("A_NAV_LIST_ARTICLES")."</a></li>";	
		echo "<li><a href=\"../clearcache.php\">".$loc->getLocString("A_NAV_EMPTY_CACHE")."</a></li>";
		echo "</ul>";
?>