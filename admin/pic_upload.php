<?php	
	session_start();
	define('IN_BCMS',true);
	if(!isset($_SESSION['login']) || $_SESSION['login']!=1) echo "No entry! <a href=\"login.php\">Please log in!</a>";
	else{
		echo"<html><head><link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\"></head><body>";
		echo "<div id=\"mainframe\">";
		if(!isset($_FILES['datei'])){
			echo"<form action=\"".htmlspecialchars ($_SERVER['PHP_SELF'])."?PHPSESSID=".session_id()."\" method=\"post\" enctype=\"multipart/form-data\">
				<input type=\"file\" name=\"datei\"><br>
				<input type=\"submit\" value=\"upload\"> 
				</form>";
		}
		else{
			include "../inc/config.php";
			$config=new Config();
			$datname=md5($_FILES['datei']['tmp_name'].$_FILES['datei']['size'].date("H:i:s"));
			list($dump,$endung)=explode(".",$_FILES['datei']['name']);
			if(!move_uploaded_file($_FILES['datei']['tmp_name'],"../upload/$datname.$endung")) {echo "Upload failed!";}
			else {
			echo"Upload successfull!\n URL:<br>
			<form>
			<input type=\"text\" class=\"linkbox\" value=\"".$config->GetValue("PATH")."/upload/$datname.$endung\">
			</form>";
			}
		}
		echo "</div>";
		echo"</body></html>";
	}
?>
