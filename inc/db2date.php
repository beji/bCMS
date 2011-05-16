<?php
/**
 * basic functions for date conversion
 * 
 * This file contains functions to convert a date between date format and db format
 * @todo check if this could be done better
 * @author beji (Bjoern Erlwein) <b.erlwein@gmx.de>
 * @package includes
 */
if(!defined('IN_BCMS')) die;
/**
 * Converts the date from the db into dd.mm.yyyy
 * @param string $date
 * @return string 
 */
function db2date($date){
	$year=substr($date,0,4);
	$month=substr($date,4,2);
	$day=substr($date,6,2);
	
	$date=$day.".".$month.".".$year;
	return $date;
}
/**
 * Converts a dd.mm.yyyy date into yyyymmdd 
 * @todo localisation
 * @param string $date the date string to be converted
 * @return string the converted date string
 */
function date2db($date){
	if(strlen($date)!=10) {echo "Falsches Datumsformat!"; die;}
	$day=substr($date,0,2);
	$month=substr($date,3,2);
	$year=substr($date,6,4);
	$date=$year.$month.$day;
	return $date;
}
?>