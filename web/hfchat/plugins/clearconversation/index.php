<?php
include dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."plugins.php";

if ($_GET['action'] == 'clear' && !empty($_POST['clearid'])) {
	$id = $_POST['clearid'];

	if (!empty($id) && !empty($_SESSION['hfchat_user_'.$id])) {
		unset($_SESSION['hfchat_user_'.$id]);
		$_SESSION['hfchat_user_'.$id.'_clear'] = getTimeStamp();
	}
}
