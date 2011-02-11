<?php session_start(); 
define('IN_BCMS',true);?>
<html>
</html>
<head>
</head>
<body>
<?php
if (isset($_POST['user']) && isset($_POST['pw'])){
	require_once "../inc/config.php";
	$query=mysql_query("SELECT  `".DB_PREFIX."users` . * 
						FROM  `".DB_PREFIX."users` 
						WHERE (
						`".DB_PREFIX."users`.`user` =  \"".$_POST['user']."\"
						)");
	echo mysql_error();
	while ($datensatz=mysql_fetch_array($query)){
		if(($datensatz['user']==$_POST['user']) && ($datensatz['password']==md5($_POST['pw'])) && ($datensatz['rank']==10)){
			$_SESSION['login']=1;
			echo "Login erfolgreich!<br><a href=\"index.php\">Hier gehts weiter!</a>";
		}
		else echo "Bitte Eingaben überprüfen!";
	}
}
else{
	echo "<form name=\"login\" method=\"post\" action=\"login.php\">";
	echo "User Name: <input type=\"text\" name=\"user\"> Passwort: <input type=\"password\" name=\"pw\">";
	echo "<input type=\"submit\" name=\"Submit\" value=\"einloggen\"></form>";
}
?>
</body>
</html>
