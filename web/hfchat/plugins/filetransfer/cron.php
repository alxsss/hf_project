<?php
$days = "1";
$seconds = ($days*24*60*60);

$dir = dirname(__FILE__)."/uploads";
$files = scandir($dir);

foreach ($files as $num => $fname){
	if (file_exists("$dir/$fname") && ((time() - filemtime("$dir/$fname")) > $seconds)) {
		if ($fname != 'index.html' && $fname != '.htaccess') {
			@unlink("$dir/$fname");
		}
	}
}