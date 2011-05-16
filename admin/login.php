<?php 
/**
 * Backend Login
 * 
 * VERY basic login script
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package backend
 * @todo make something better
 */
session_start();
define('IN_BCMS',true);?>
<html>
</html>
<head>
</head>
<body>
<?php
if (isset($_POST['user']) && isset($_POST['pw'])){
	require_once "../inc/config.php";
	include_once "../inc/loc.php";
	if(!isset($loc) && !is_object($loc)){
		$loc = new Loc();
	}
	$query=mysql_query("SELECT  `".DB_PREFIX."users` . * 
						FROM  `".DB_PREFIX."users` 
						WHERE (
						`".DB_PREFIX."users`.`user` =  \"".$_POST['user']."\"
						)");
	echo mysql_error();
	while ($datensatz=mysql_fetch_array($query)){
		if(($datensatz['user']==$_POST['user']) && ($datensatz['password']==md5($_POST['pw'])) && ($datensatz['rank']==10)){
			$_SESSION['login']=1;
			echo $loc->getLocString("A_LOGIN_SUCCESS");
		}
		else echo $loc->getLocString("A_LOGIN_FAILED");
	}
}
else{
	include_once "../inc/loc.php";
	if(!isset($loc) && !is_object($loc)){
		$loc = new Loc();
	}
	echo "<form name=\"login\" method=\"post\" action=\"login.php\">";
	echo "User Name: <input type=\"text\" name=\"user\"> ".$loc->getLocString("PASS").": <input type=\"password\" name=\"pw\">";
	echo "<input type=\"submit\" name=\"Submit\" value=\"".$loc->getLocString("LOGIN")."\"></form>";
}
?>
</body>
</html>
