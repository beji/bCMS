<?php
if(!defined('IN_BCMS')) die;
//Basic functions to turn a DD.MM.YYYY string into the date format required by the database (DDMMYY) and vice-versa

function db2date($date){
	$day=substr($date,0,2);
	$month=substr($date,2,2);
	$year=substr($date,4,4);
	$date=$day.".".$month.".".$year;
	return $date;
}
function date2db($date){
	if(strlen($date)!=10) {echo "Falsches Datumsformat!"; die;}
	$date=str_replace(".","",$date);
	return $date;
}
?>