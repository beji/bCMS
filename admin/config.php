<?php
$SITEVARS['DB_PREFIX']="fbcms_";

include "../inc/sqldata.php";

function createsitevars(){
	global $SITEVARS;
	$lines = file("../inc/sitevars.conf", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line_num => $line) {
		list($var,$content)=explode("=",$line);
		$SITEVARS[$var]=$content;
	}
}
?>