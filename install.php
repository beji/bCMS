<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>bCMS Setup</title>
	<style type="text/css">
		label{
			font-weight:bold;
		}
		.error{
			color:red;
		}
		.success{
			color:green;
		}
	</style>
</head>
<body>
	
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(!isset($_GET['step']) || $_GET['step']==1){
	echo "<h1>Database Informations</h1>";
	echo "<form method=\"post\" name=\"formular\" action=\"install.php?step=2\">\n
			<label for=\"mysqlhost\">MySQL Host</label>
			<input name=\"mysqlhost\" type=\"text\">
			<p>Your SQL Host - usually localhost</p>
			<label for=\"mysqldb\">MySQL Database</label>
			<input name=\"mysqldb\" type=\"text\">
			<p>Name of the Database</p>
			<label for=\"mysqluser\">MySQL User</label>
			<input name=\"mysqluser\" type=\"text\">
			<p>Your SQL User</p>
			<label for=\"mysqlpass\">MySQL Password</label>
			<input name=\"mysqlpass\" type=\"password\">
			<p>Your SQL Password</p>
			<label for=\"dbprefix\">Prefix for bCMS tables</label>
			<input name=\"dbprefix\" type=\"text\">
			<p>The Prefix for the bCMS tables inside the Database (e.g. bcms_)</p>
			<input type=\"submit\" value=\"To Step 2\"></form>";
}
elseif($_GET['step']==2){
	$error=0;
	if(!isset($_POST['mysqlhost']) || $_POST['mysqlhost']==""){
		echo "<p class=\"error\">MySQL Host not set!</p>";
		$error++;
	}
	if(!isset($_POST['mysqldb']) || $_POST['mysqldb']==""){
		echo "<p class=\"error\">MySQL DB not set!</p>";
		$error++;
	}		
	if(!isset($_POST['mysqluser']) || $_POST['mysqluser']==""){
		echo "<p class=\"error\">MySQL User not set!</p>";
		$error++;
	}
	if(!isset($_POST['mysqlpass'])){
		echo "<p class=\"error\">MySQL Password not set!</p>";
		$error++;
	}
	if(!isset($_POST['dbprefix']) || $_POST['dbprefix']==""){
		echo "<p class=\"error\">Database prefix not set!</p>";
		$error++;
	}
	if ($error>0){
		die("There has been a problem with your inputs. <a href=\"install.php\">Please repeat Step 1</a>");
	}
	echo "Trying to connect to Database Host... ";
	$link = mysql_connect($_POST['mysqlhost'], $_POST['mysqluser'], $_POST['mysqlpass']);
	if (!$link) {
		die('<p class=\"error\">Connection could not be established: ' . mysql_error().'</p>');
	}
	else echo "<p class=\"success\">success</p>";
	echo "<br>Trying to access database... ";
	$db=mysql_select_db($_POST['mysqldb']);
	if (!$db) {
		echo "Database could not be accessed, trying to create database...";
		$db=mysql_create_db($_POST['mysqldb']);
		if (!$db) {
			die("<p class=\"error\">The database ".$_POST['mysqldb']." was not found and could not be created: " . mysql_error()."</p>");
		}
		else echo "<p class=\"success\">success</p>";
	}
	else echo "<p class=\"success\">success</p>";
	echo "<br>Writing sqldata.php...";
	
	$content="<?php\n
if(!defined('IN_BCMS')) die;
define('MYSQL_HOST','".$_POST['mysqlhost']."');
define('MYSQL_USER','".$_POST['mysqluser']."');
define('MYSQL_PASS','".$_POST['mysqlpass']."');
define('MYSQL_DATABASE','".$_POST['mysqldb']."');
define('DB_PREFIX','".$_POST['dbprefix']."');
mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
mysql_select_db(MYSQL_DATABASE);
?>";
	if (is_writable("./inc/sqldata.php")) {
		if (!$handle = fopen("./inc/sqldata.php", "w+")) {
			 die("<p class=\"error\">Could not open the file</p>");
		}
		if (!fwrite($handle, $content)) {
			die("<p class=\"error\">Could not write the file</p>");
		}
	}
	else {
		die("<p class=\"error\">Could not open the file</p>");
	}
	echo "<p class=\"success\">success</p>";
	echo "<form method=\"post\" name=\"formular\" action=\"install.php?step=3\"><input type=\"submit\" value=\"To Step 3\"></form>";
}
elseif($_GET['step']==3){
	echo "<h1>Setup</h1>";
	echo "<form method=\"post\" name=\"formular\" action=\"install.php?step=4\">\n
		<label for=\"admin_acc\">Admin account</label>
		<input name=\"admin_acc\" type=\"text\">
		<p>The admin account for the CMS</p>
		<label for=\"admin_pw\">Password</label>
		<input name=\"admin_pw\" type=\"password\">
		<p>The password for the admin account</p>
		<label for=\"title\">Title</label>
		<input name=\"title\" type=\"text\" value=\"bCMS\">
		<p>The Title displayed in the header of the Browser</p>
		<label for=\"head_title\">Head Title</label>
		<input name=\"head_title\" type=\"text\" value=\"bCMS\">
		<p>Text displayed instead of {HEAD_TITLE}</p>
		<label for=\"caching\">Caching</label>
		<input name=\"caching\" type=\"text\" value=\"0\">
		<p>Enable Caching (0 = disabled, 1 = enabled)</p>
		<input type=\"submit\" value=\"To Step 4\"></form>";
}
elseif($_GET['step']==4){
	define('IN_BCMS',true);
	require "./inc/sqldata.php";
	$error=0;
	if(!isset($_POST['admin_acc']) || $_POST['admin_acc']==""){
		echo "<p class=\"error\">Admin account not set!</p>";
		$error++;
	}
	if(!isset($_POST['admin_pw']) || $_POST['admin_pw']==""){
		echo "<p class=\"error\">Password not set!</p>";
		$error++;
	}		
	if(!isset($_POST['title']) || $_POST['title']==""){
		echo "<p class=\"error\">Title not set!</p>";
		$error++;
	}	
	if(!isset($_POST['head_title']) || $_POST['head_title']==""){
		echo "<p class=\"error\">Head title not set!</p>";
		$error++;
	}
	if(!isset($_POST['caching']) || $_POST['caching']==""){
		echo "<p class=\"error\">No value for caching set</p>";
		$error++;
	}
	elseif($_POST['caching']!=0 && $_POST['caching']!=1){
		echo "<p class=\"error\">No valid value for caching set</p>";
		$error++;
	}
	if ($error>0){
		die("There has been a problem with your inputs. <a href=\"install.php\">Please repeat Step 1</a>");
	}

	echo "Setting up the tables...";
	$query=mysql_query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."config` (
		  `key` varchar(100) NOT NULL,
		  `value` varchar(100) NOT NULL,
		  `description` mediumtext NOT NULL,
		  PRIMARY KEY (`key`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;"
	);
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}	
	$query=mysql_query("
		INSERT INTO `".DB_PREFIX."config` (`key`, `value`, `description`) VALUES
		('TITLE', '".$_POST['title']."', 'The Title displayed in the header of the Browser (see <title> tag in Template)'),
		('HEAD_TITLE', '".$_POST['head_title']."', 'Text displayed instead of {HEAD_TITLE}'),
		('TEMPLATE', 'standard', 'Name of the active Template'),
		('CACHING', '".$_POST['caching']."', '0 = Caching deactivated,\r\n1 = Caching active'),
		('PATH', '".str_replace("\\","/",dirname(__FILE__))."', 'The directory the CMS is located'),
		('ARTICLES_PER_PAGE', '5', 'Shown articles per page');"
	);
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}
	$query=mysql_query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."categories` (
		  `alias` varchar(30) NOT NULL,
		  `name` varchar(30) NOT NULL,
		  `link` varchar(30) NOT NULL,
		  `pos` int(3) NOT NULL,
		  PRIMARY KEY (`alias`),
		  UNIQUE KEY `Pos` (`pos`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;"
	);
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}
	$query=mysql_query("
		INSERT INTO `".DB_PREFIX."categories` (`alias`, `name`, `link`, `pos`) VALUES
		('news', 'News', 'index.php', 1),
		('admin', 'Login', './admin/index.php', 4);"
	);	
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}	
	$query=mysql_query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."content` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `date` varchar(8) NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `content` mediumtext NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `id` (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;"
	);	
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}	
	$query=mysql_query("
		INSERT INTO `".DB_PREFIX."content` (`id`, `date`, `title`, `content`) VALUES
		(1, '".date("Ymd")."', 'Success!', '<p>Your bCMS has been installed!</p>');"
	);	
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}
	$query=mysql_query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."cat_cont` (
		  `cat_alias` varchar(30) NOT NULL,
		  `cont_id` int(5) NOT NULL,
		  PRIMARY KEY (`cat_alias`,`cont_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;"
	);
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}
	$query=mysql_query("
		INSERT INTO `".DB_PREFIX."cat_cont` (`cat_alias`, `cont_id`) VALUES
		('news', 1);"
	);
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}
	$query=mysql_query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."users` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `user` varchar(255) NOT NULL,
		  `password` varchar(255) NOT NULL,
		  `rank` int(10) unsigned NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;"
	);
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}
	$query=mysql_query("
		INSERT INTO `".DB_PREFIX."users` (`id`, `user`, `password`, `rank`) VALUES
		(1, '".$_POST['admin_acc']."', '".md5($_POST['admin_pw'])."', 10);"
	);
	if (!$query) {
		die("<p class=\"error\">The database could not be written: " . mysql_error()."</p>");
	}
	echo "<p class=\"success\">Done! Your bCMS should be working. Please delete install.php now!</p>
	<a href=\"index.php\">To your bCMS</a>";
}
?>
	
</body>
</html>