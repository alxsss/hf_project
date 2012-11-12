<?php
include_once dirname(__FILE__)."/hfchat_init.php";

$response = array();
$messages = array();

$fetchid = $_POST['userid'];

$time = getTimeStamp();
$sql = getUserDetails($fetchid);
$query = mysql_query($sql);

if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

$chat = mysql_fetch_array($query);

if ((($time-processTime($chat['lastactivity'])) < ONLINE_TIMEOUT) && $chat['status'] != 'invisible' && $chat['status'] != 'offline') {
	if ($chat['status'] != 'busy') {
		$chat['status'] = 'available';
	}
} else {
	$chat['status'] = 'offline';
}

if ($chat['message'] == null) {
	$chat['message'] = $status[$chat['status']];
}

$link = getLink($chat['link']);
$avatar = getAvatar($chat['avatar']);

if (function_exists('processName')) {
	$chat['username'] = processName($chat['username']);
}

$response =  array('id' => $chat['userid'], 'n' => $chat['username'], 's' => $chat['status'], 'm' => $chat['message'], 'a' => $avatar, 'l' => $link);

header('Content-type: application/json; charset=utf-8');
echo json_encode($response);
exit;
?>
