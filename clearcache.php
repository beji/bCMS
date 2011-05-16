<?php
/**
 * Temporary file for deleting the cache
 * 
 * Used to clear the cache from the backend - not included in the backend right now
 * 
 * @deprecated will be replaced once the caching is rewritten
 * @todo rewrite caching
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package main_files
 */
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