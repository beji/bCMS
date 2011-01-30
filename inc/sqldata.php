<?php
if(!defined('IN_BCMS')) die;
define('MYSQL_HOST','localhost');
define('MYSQL_USER','root');
define('MYSQL_PASS','');
define('MYSQL_DATABASE','fbcms');
define('DB_PREFIX','fbcms_');
mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
mysql_select_db(MYSQL_DATABASE);
?>