<?php
if(!defined('IN_BCMS')) die;
include_once "../inc/config.php";
include_once "../inc/loc.php";
include "../inc/db2date.php";
if(!isset($loc) && !is_object($loc)){
	$loc = new Loc();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
$query = "SELECT `".DB_PREFIX."categories`.`alias`, `".DB_PREFIX."categories`.`name`
FROM `".DB_PREFIX."categories`";

$result = mysql_query($query);
while ($cat=mysql_fetch_array($result)){
    echo '<a href="index.php?id=list_articles&cat='.$cat['alias'].'">'.$cat['name'].'</a> ';
};

if(isset($_GET['cat']) && (strpos($_GET['cat']," "===false))){
    $query = "SELECT  `bcms_content` . *
FROM  `bcms_cat_cont`
LEFT JOIN  `bcms`.`bcms_content` ON  `bcms_cat_cont`.`cont_id` =  `bcms_content`.`id`
WHERE (
`bcms_cat_cont`.`cat_alias` =  '".$_GET['cat']."'
)";
    
}
else{
   $query = "SELECT `".DB_PREFIX."content`.* FROM `".DB_PREFIX."content`";
}
$result = mysql_query($query);
echo mysql_error();
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
<th>".$loc->getLocString("A_OPS")."</th>\n

";
while ($data=mysql_fetch_array($result)){
	$catsql="SELECT  `".DB_PREFIX."categories` . * 
			FROM  `".DB_PREFIX."cat_cont` 
			LEFT JOIN  `".MYSQL_DATABASE."`.`".DB_PREFIX."categories` ON  `".DB_PREFIX."cat_cont`.`cat_alias` =  `".DB_PREFIX."categories`.`alias` 
			WHERE (
			`".DB_PREFIX."cat_cont`.`cont_id` =  ".$data['id']."
			)";
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
	$opstring = "<a href=\"index.php?id=edit_content&aid=".$data['id']."\">".$loc->getLocString("EDIT")."</a>";
	echo "<tr>
		<td>".$data['id']."</td>\n
		<td>".db2date($data['date'])."</td>\n
		<td>".$data['title']."</td>\n
		<td>".$cont."</td>\n
		<td>".$catstring."</td>\n
		<td>".$opstring."</td>\n

	</tr>";
}

?>