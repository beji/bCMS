<?php
		if(!defined('IN_BCMS')) die;
		include_once "../inc/loc.php";
		if(!isset($loc)){
			$loc = new Loc();
		}
		echo "<ul>";
		echo "<li><a href=\"index.php?id=add_content\">".$loc->getLocString("A_NAV_ADD_ARTICLE")."</a></li>";
		//echo "<li><a href=\"list_articles.php\">Content&uuml;bersicht</a></li>";
		echo "<li><a href=\"../clearcache.php\">".$loc->getLocString("A_NAV_EMPTY_CACHE")."</a></li>";
		echo "</ul>";
?>