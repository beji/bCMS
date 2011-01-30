<?php session_start();
$_SESSION['ls']=0; ?>
<html>
</html>
<head>
</head>
<body>
<?php
if (isset($_POST['user']) && isset($_POST['pw'])){
	include "./config.php";
	$query=mysql_query("SELECT * FROM ".$SITEVARS['DB_PREFIX']."users");
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
