<?php
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'hfchat_shared.php';
//include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'php4functions.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'comet.php';
if (SET_SESSION_NAME != '') {
	session_name(SET_SESSION_NAME);
}
if (DO_NOT_START_SESSION != 1) {
	session_start();
}
function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}
if (get_magic_quotes_gpc() || (defined('FORCE_MAGIC_QUOTES') && FORCE_MAGIC_QUOTES == 1)) {
	$_GET = stripSlashesDeep($_GET);
	$_POST = stripSlashesDeep($_POST);
	$_COOKIE = stripSlashesDeep($_COOKIE);
}
if(get_magic_quotes_runtime()) { 
    set_magic_quotes_runtime(false); 
} 
ini_set('log_errors', 'Off');
ini_set('display_errors','Off');
if (defined('ERROR_LOGGING') && ERROR_LOGGING == '1') { 
	error_reporting(E_ALL);
	ini_set('error_log', 'error.log');
	ini_set('log_errors', 'On');
}
if (defined('DEV_MODE') && DEV_MODE == '1') { 
	error_reporting(E_ALL);
	ini_set('display_errors','On');
}
$dbh = mysql_connect(DB_SERVER.':'.DB_PORT,DB_USERNAME,DB_PASSWORD);
if (!$dbh) {
	echo "<h3>Unable to connect to database. Please check details in configuration file.</h3>";
	exit();
}
mysql_selectdb(DB_NAME,$dbh);
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");  
$userid = getUserID();
if (empty($_SESSION['timedifference'])) {
	$_SESSION['timedifference'] = 0;
}
?>
