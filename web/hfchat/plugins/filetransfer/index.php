<?php
include dirname(dirname(dirname(__FILE__)))."/plugins.php";

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

$toId = $_GET['id'];

echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>{$filetransfer_language[0]}</title> 
<link type="text/css" rel="stylesheet" media="all" href="themes/{$theme}/filetransfer{$rtl}.css" /> 
<script type="text/javascript" src="styleinput.js"></script>
</head>

<body><form name="upload" action="upload.php" method="post" enctype="multipart/form-data">
<div class="container">
<div class="container_title">{$filetransfer_language[1]}</div>

<div class="container_body">

<div class="container_body_1">{$filetransfer_language[2]}</div>
<div id="select-0" class="container_body_2"><label class="cabinet"><input type="file" class="file" name="Filedata" onchange="javascript:document.upload.submit()"/></label></div>

<div class="container_body_3">{$filetransfer_language[4]}</div>
<div style="clear:both"></div>


<div class="container_body_4">{$filetransfer_language[3]}</div>

<input type="hidden" name="to" value="{$toId}">

</div>
</div>
</div>

<script>
SI.Files.stylizeAll();
</script>
</form>
</body>
</html>
EOD;
