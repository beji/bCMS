<?php
//Dummy um ein frisches System mit Inhalt zu füllen, nix finales ;)

require "inc/config.php";

function createusertable(){
	global ;
	echo "Usertable wird erstellt<br>";
	$query=mysql_query("CREATE TABLE  `fbcms`.`".DB_PREFIX."users` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
	`user` VARCHAR( 255 ) NOT NULL ,
	`password` VARCHAR( 255 ) NOT NULL ,
	`rank` INT UNSIGNED NOT NULL ,
	PRIMARY KEY (  `id` )S
	) ENGINE = MYISAM");
}
function createadmin(){
	global ;
	echo "Adminuser wird erstellt<br>";
	$query=mysql_query("INSERT INTO ".DB_PREFIX."users(user,password,rank) VALUES('admin','".md5("root")."',10)");
}
function createnavitable(){
	global ;
	echo "Navitable wird erstennt<br>";
	$query=mysql_query("CREATE TABLE  `fbcms`.`".DB_PREFIX."categories` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
	`alias` VARCHAR( 255 ) NOT NULL ,
	`name` VARCHAR( 255 ) NOT NULL ,
	`link` VARCHAR( 255 ) NOT NULL ,
	PRIMARY KEY (  `id` )
	) ENGINE = MYISAM");
}
function createtestnavi(){
	global ;
	echo "Testnavi wird erstellt<br>";
	$query=mysql_query("INSERT INTO ".DB_PREFIX."categories(alias,name,link) VALUES('news','Startseite','index.php'),('picture','Mit Bild','index.php?id=picture'),('leerzeichen_test','Leerzeichen Test','index.php?id=leerzeichen_test')");
}

//HIER WIRD AUCH TATSÄCHLICH WAS GETAN

//createusertable();
//createadmin();
createnavitable();
createtestnavi();
?>