<?php
/**
 * Page for adding content
 * 
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package backend
 */
if(!defined('IN_BCMS')) die;
include_once "../inc/config.php";
include_once "../inc/loc.php";
if(!isset($loc) && !is_object($loc)){
	$loc = new Loc();
}
if(!isset($_POST['content'])){

	echo "<form method=\"post\" name=\"formular\" action=\"index.php?id=add_content\">\n
			<label for=\"title\">".$loc->getLocString("TITLE")."</label>
			<input name=\"title\" type=\"text\"><br>
			<label for=\"title\">".$loc->getLocString("DATE")."</label>
			<input name=\"date\" type=\"text\"><br>
			<textarea id=\"cont\" class=\"mce\" name=\"content\" cols=\"50\" rows=\"15\"></textarea>";
	$query=mysql_query("SELECT name,alias FROM ".DB_PREFIX."categories ORDER BY pos ASC");
	$num_rows=mysql_query("SELECT pos FROM ".DB_PREFIX."categories");
	echo "<br><br>";
	echo "<label for\"categories[]\">".$loc->getLocString("CATS")."</label><br>";
	echo "<select name=\"categories[]\" size=\"".mysql_num_rows($num_rows)."\" multiple>";
	while($datensatz=mysql_fetch_array($query)){
		echo"<option value=\"".$datensatz['alias']."\">".$datensatz['name']."(".$datensatz['alias'].")</option>";
	}
	echo "</select>";
	echo "<input type=\"submit\" value=\"save\">
		</form>\n";
		echo "<br><a href=\"pic_upload.php\" onclick=\"FensterOeffnen(this.href); return false\">".$loc->getLocString("A_PIC_UPLOAD")."</a>";
}
else{
	include "../inc/db2date.php";
	echo $loc->getLocString("A_SAVING_ARTICLE")."<br>";
	$date=date2db($_POST['date']);
	$insertquery="INSERT INTO ".DB_PREFIX."content(date,title,content) 
				VALUES('".$date."','".$_POST['title']."','".$_POST['content']."')";
	$query=mysql_query($insertquery);
	if($query){
		echo $loc->getLocString("A_ARTICLE_SAVED")."<br>";
		$getid="SELECT  `".DB_PREFIX."content`.`id` 
				FROM  `".DB_PREFIX."content` 
				WHERE (
				(
				`".DB_PREFIX."content`.`title` =  '".$_POST['title']."'
				)
				AND (
				`".DB_PREFIX."content`.`content` =  '".$_POST['content']."'
				)
				)";
		$query=mysql_query($getid);
		if($query){
			$datensatz=mysql_fetch_array($query);
			echo $loc->getLocString("A_ID_FOUND").": ".$datensatz['id'];
			foreach($_POST['categories'] as $cat){
				$cat_cont_insert="INSERT INTO  `".DB_PREFIX."cat_cont` (
								`cat_alias` ,
								`cont_id`
								)
								VALUES (
								'".$cat."',  '".$datensatz['id']."'
								);";
				$query=mysql_query($cat_cont_insert);
			}
			echo "<br>".$loc->getLocString("A_ARTICLE_ADDED")."!";
		}
		else echo mysql_error();
	}
}
?>