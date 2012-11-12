<?php
include (dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."plugins.php");

if (!in_array('filetransfer',$plugins)) {
	echo "Access denied. Please contact administrator.";
	exit;
}

if (file_exists(dirname(__FILE__)."/lang/".$lang.".php")) {
	include dirname(__FILE__)."/lang/".$lang.".php";
} else {
	include dirname(__FILE__)."/lang/en.php";
}

if ($rtl == 1) {
	$rtl = "_rtl";
} else {
	$rtl = "";
}

if (!file_exists(dirname(__FILE__)."/themes/".$theme."/filetransfer".$rtl.".css")) {
	$theme = "default";
}

$message = '';

$filename = preg_replace("/[^a-zA-Z0-9 ]/", "", $_FILES['Filedata']['name']);
$filename = str_replace(" ", "_", $filename);
$md5filename = md5($filename."hfchat");

if (!(!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name']))) {
	if (!move_uploaded_file($_FILES['Filedata']['tmp_name'], dirname(__FILE__).'/uploads/' . $md5filename)) {
		$message = 'An error has occurred. Please contact administrator. Closing Window.';
	}
}

if (empty($message)) {
	sendMessageTo($_POST['to'],$filetransfer_language[5]." (".$_FILES['Filedata']['name']."). <a href=\"".BASE_URL."plugins/filetransfer/download.php?file=".$_FILES['Filedata']['name']."\" target=\"_blank\">".$filetransfer_language[6]."</a>");
	sendSelfMessage($_POST['to'],$filetransfer_language[7]." (".$_FILES['Filedata']['name'].").");

	$message = $filetransfer_language[8];
}

echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>{$filetransfer_language[0]}</title> 
<link type="text/css" rel="stylesheet" media="all" href="themes/{$theme}/filetransfer{$rtl}.css" /> 

<script type="text/javascript" src="styleinput.js"></script>


</head>
<body onload="setTimeout('window.close()',2000);"><form action="upload.php" method="post" enctype="multipart/form-data">
<div class="container">
<div class="container_title">{$filetransfer_language[1]}</div>

<div class="container_body">

<div>$message</div>

<div style="clear:both"></div>

</div>
</div>
</div>
</form>
</body>
</html>
EOD;
?>
