<?php
	define('IN_BCMS',true);
	include "../inc/config.php";
	if(!isset($_POST['content'])){

		echo "<form method=\"post\" name=\"formular\" action=\"index.php?id=add_content\">\n
				<label for=\"title\">Title</label>
				<input name=\"title\" type=\"text\"><br>
				<label for=\"title\">Date</label>
				<input name=\"date\" type=\"text\"><br>
				<textarea id=\"cont\" class=\"mce\" name=\"content\" cols=\"50\" rows=\"15\"></textarea>";
		$query=mysql_query("SELECT name,alias FROM ".DB_PREFIX."categories ORDER BY pos ASC");
		$num_rows=mysql_query("SELECT pos FROM ".DB_PREFIX."categories");
		echo "<br><br>";
		echo "<label for\"categories[]\">Kategorien</label><br>";
		echo "<select name=\"categories[]\" size=\"".mysql_num_rows($num_rows)."\" multiple>";
		while($datensatz=mysql_fetch_array($query)){
			echo"<option value=\"".$datensatz['alias']."\">".$datensatz['name']."(".$datensatz['alias'].")</option>";
		}
		echo "</select>";
		echo "<input type=\"submit\" value=\"save\">
			</form>\n";
			echo "<br><a href=\"pic_upload.php\" onclick=\"FensterOeffnen(this.href); return false\">---Upload a picture---(Popup)</a>";
	}
	else{
		include "../inc/db2date.php";
		echo "Saving article<br>";
		$date=date2db($_POST['date']);
		$insertquery="INSERT INTO ".DB_PREFIX."content(date,title,content) 
					VALUES('".$date."','".$_POST['title']."','".$_POST['content']."')";
		$query=mysql_query($insertquery);
		if($query){
			echo "article saved<br>";
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
				echo "ID gefunden: ".$datensatz['id'];
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
				echo "<br>article successfully added!";
			}
			else echo mysql_error();
		}
	}
?>