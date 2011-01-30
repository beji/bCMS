<?php
//In the main directory because the whole cache class is build around that fact, need to find an elegant way around this
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1) echo "Kein Zugang! <a href=\"/admin/login.php\">Erstmal einloggen!</a>";
else{
	require "./inc/config.php";
	include "./inc/cache.php";
	$cache = new Cache();
	$cache->clearcache();
	echo "Fertig!";
	}

?>