<?php
if(!defined('IN_BCMS')) die;
include_once "../inc/config.php";
include_once "../inc/loc.php";
include "../inc/db2date.php";
if(!isset($loc) && !is_object($loc)){
	$loc = new Loc();
}
$query = "SELECT `".DB_PREFIX."content`.* FROM `".DB_PREFIX."content`";
$result = mysql_query($query);
if(!$result){
	include_once "../inc/log.php";
	$log = new Log();
	$log->writeErrorLog(__FILE__,__LINE__,mysql_error());
}
echo "<table class=\"artl\">\n
<th>".$loc->getLocString("A_ID")."</th>\n
<th>".$loc->getLocString("DATE")."</th>\n
<th>".$loc->getLocString("TITLE")."</th>\n
<th>".$loc->getLocString("A_CONTENT")."</th>\n
<th>".$loc->getLocString("CATS")."</th>\n
";
while ($data=mysql_fetch_array($result)){
	$catsql="SELECT  `".DB_PREFIX."categories` . * 
		FROM  `".DB_PREFIX."cat_cont` 
		LEFT JOIN  `fbcms`.`".DB_PREFIX."categories` ON  `".DB_PREFIX."cat_cont`.`cat_alias` =  `".DB_PREFIX."categories`.`alias` 
		WHERE (
		`".DB_PREFIX."cat_cont`.`cont_id` = ".$data['id']."
		)";
	echo mysql_error();
	$catquery=mysql_query($catsql);
	$catnum=mysql_num_rows($catquery);
	$catstring="";
	$i=1;
	while ($cats=mysql_fetch_array($catquery)){
		$catstring.=$cats['alias'];
		$catstring.=($i<$catnum) ? ", " : "";
		$i++;
	}
	$cont=htmlentities($data['content']);
	if(strlen($cont)>50){
		$cont=substr($cont,0,50)."...";
	}
	echo "<tr>
		<td>".$data['id']."</td>\n
		<td>".db2date($data['date'])."</td>\n
		<td>".$data['title']."</td>\n
		<td>".$cont."</td>\n
		<td>".$catstring."</td>\n

	</tr>";
}

?>