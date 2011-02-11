<?php
session_start();
define('IN_BCMS',true);
if(!isset($_SESSION['login']) || $_SESSION['login']!=1) echo "Kein Zugang! <a href=\"login.php\">Erstmal einloggen!</a>";
else{
	echo"<html><head><link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
		<script type=\"text/javascript\" src=\"../tiny_mce/tiny_mce.js\"></script>
		<script type=\"text/javascript\">
		tinyMCE.init({
			theme : \"advanced\",
			mode : \"exact\",
			elements : \"cont\",
			theme_advanced_toolbar_location : \"top\",
			content_css : \"../inc/mce.css\",
			relative_urls : false,
			width : \"80%\",
		});
		</script>
		<script type=\"text/javascript\">
		function fill_in(text){
		if(document.formular.categories.value!=\"\") document.formular.categories.value+=',';
		 document.formular.categories.value+=text;
		}
		</script>
		</head><body>";
	echo "<div id=\"nav\">";
	include "nav.php";
	echo "</div>";
	echo "<div id=\"mainframe\">";
	if(!isset($_GET['id'])){
		echo "Keine ID angegeben!";
	}
	else{
		include "./config.php";
		include "../inc/db2date.php";
		$id=intval($_GET['id']);
		if(!isset($_POST['content'])){
			$query=mysql_query("SELECT * FROM ".$SITEVARS['DB_PREFIX']."content WHERE id='".$id."'");
			$datensatz=mysql_fetch_array($query);
			echo "<form method=\"post\" name=\"formular\" action=\"edit_content.php?PHPSESSID=".session_id()."&id=".$id."\">
					<label for=\"title\">Titel</label>
					<input name=\"title\" type=\"text\" value=\"".$datensatz['title']."\"><br>
					<label for=\"title\">Datum</label>
					<input name=\"date\" type=\"text\" value=\"".$datensatz['date']."\"><br>
					<textarea id=\"cont\" class=\"mce\" name=\"content\" cols=\"50\" rows=\"15\">".$datensatz['content']."</textarea>
					<label for=\"title\">Kategorien</label>
					<input name=\"categories\" type=\"text\" value=\"".substr($datensatz['categories'],2)."\">
					<input type=\"submit\" value=\"Speichern\">";
			$catquery=mysql_query("SELECT * FROM ".$SITEVARS['DB_PREFIX']."categories ORDER BY id ASC");
			while($cats=mysql_fetch_array($catquery)){
				echo "<br><input type=\"button\" value=\"".$cats['name']."\" onClick=\"javaScript: fill_in('".$cats['alias']."');\">";
			}
			echo "</form>";
		}
		else{
			$query=mysql_query("UPDATE ".$SITEVARS['DB_PREFIX']."content
			SET
			date='".date2db($_POST['date'])."',
			title='".$_POST['title']."',
			content='".$_POST['content']."',
			categories='0,".$_POST['categories']."'
			WHERE id = '".$id."'");
		}
	}
	echo"</div></body></html>";
}

?>