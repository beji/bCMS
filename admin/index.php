<?php		session_start();	if(!isset($_SESSION['login']) || $_SESSION['login']!=1) echo "Kein Zugang! <a href=\"login.php\">Erstmal einloggen!</a>";	else{		echo"<html><head><link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">";		echo "<script type=\"text/javascript\" src=\"../tiny_mce/tiny_mce.js\"></script>\n			<script type=\"text/javascript\" src=\"mce_cfg.js\"></script>\n";		echo "<script type=\"text/javascript\">			function FensterOeffnen (Adresse) {			  MeinFenster = window.open(Adresse, \"Zweitfenster\", \"width=300,height=400,left=100,top=200\");			  MeinFenster.focus();			}</script>";		echo"</head><body>";		echo "<div id=\"nav\">";		include "nav.php";		echo "</div>";		echo "<div id=\"mainframe\">";		if(isset($_GET['id'])) include $_GET['id'].".php";		echo "</div>";		echo"</body></html>";	}?>