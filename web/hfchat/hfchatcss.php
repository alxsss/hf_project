<?php
include_once (dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");
$useragent = (isset($_SERVER["HTTP_USER_AGENT"]) ) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;
if (phpversion() >= '4.0.4pl1' && (strstr($useragent,'compatible') || strstr($useragent,'Gecko'))) {
	if (extension_loaded('zlib') && GZIP_ENABLED == 1) {
		ob_start('ob_gzhandler');
	}
}
header('Content-type: text/css;');
header('Expires: '.gmdate("D, d M Y H:i:s", time() + 3600*24*365).' GMT');
if ($rtl == 1) {
	include_once (dirname(__FILE__)."/themes/".$theme."/css/hfchat_rtl.css");
} else {
	include_once (dirname(__FILE__)."/themes/".$theme."/css/hfchat.css");
}
?>
