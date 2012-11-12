<?php
include dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."config.php";

if (!in_array('filetransfer',$plugins)) {
	echo "Access denied. Please contact administrator.";
	exit;
}

$filename = preg_replace("/[^a-zA-Z0-9 ]/", "", $_GET['file']);
$filename = str_replace(" ", "_", $filename);


if (file_exists(dirname(__FILE__).'/uploads/' . md5($filename."hfchat"))) {
	header('Content-Description: File Transfer');
	header('Content-Type: application/force-download');
	header('Content-Disposition: attachment; filename='.$_GET['file']);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize(dirname(__FILE__).'/uploads/' . md5($filename."hfchat")));
	ob_clean();
	flush();
	readfile(dirname(__FILE__).'/uploads/' . md5($filename."hfchat"));
} else {
	header("HTTP/1.0 404 Not Found");
}