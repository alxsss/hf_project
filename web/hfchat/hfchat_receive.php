<?php
include_once dirname(__FILE__).DIRECTORY_SEPARATOR."hfchat_init.php";
include_once dirname(__FILE__).DIRECTORY_SEPARATOR."license.php";

//include_once dirname(__FILE__)."/license.php";
//include_once dirname(__FILE__)."/hfchat_init.php";
$response = array();
$messages = array();
$lastPushedAnnouncement = 0;
function getbuddylist() {
	global $response;
	global $userid;
	global $db;
	global $status;
	$time = getTimeStamp();
	$buddyList = array();
	if ((empty($_SESSION['hfchat_buddytime'])) || ($_POST['initialize'] == 1) || (!empty($_SESSION['hfchat_buddytime']) && ($time-$_SESSION['hfchat_buddytime'] > REFRESH_BUDDYLIST))) {
		$sql = getFriendsList($userid,$time);
		$query = mysql_query($sql);
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
		while ($chat = mysql_fetch_array($query)) {
			if ((($time-processTime($chat['lastactivity'])) < ONLINE_TIMEOUT) && $chat['status'] != 'invisible' && $chat['status'] != 'offline') {
				if ($chat['status'] != 'busy' && $chat['status'] != 'away') {
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
			if (!empty($chat['username'])) {
				$buddyList[] = array('id' => $chat['userid'], 'n' => $chat['username'], 's' => $chat['status'], 'm' => $chat['message'], 'a' => $avatar, 'l' => $link);
			}
		}
		if (function_exists('hooks_forcefriends') && is_array(hooks_forcefriends())) {
			$buddyList = array_merge(hooks_forcefriends(),$buddyList);
		}
		$_SESSION['hfchat_buddytime'] = $time;
		$blh = md5(serialize($buddyList));
		if ((empty($_POST['blh'])) || (!empty($_POST['blh']) && $blh != $_POST['blh'])) {
			$response['buddylist'] = $buddyList;
			$response['blh'] = $blh;
		}
	}
}
function getStatus() {
	global $response;
	global $userid;
	global $status;
	$sql = getUserStatus($userid);
 	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	$chat = mysql_fetch_array($query);
	if (empty($chat['status'])) {
		$chat['status'] = 'available';
	} else {
		if ($chat['status'] == 'away') {
			$chat['status'] = 'available';
			setStatus('available');
		}
		if ($chat['status'] == 'offline') {
			$_SESSION['hfchat_sessionvars']['buddylist'] = 0;
		}
	}
	if (empty($chat['message'])) {
		$chat['message'] = $status[$chat['status']];		
	}
	$chat['message'] = strip_tags($chat['message']);
	$chat['message'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$chat['message']); 
	$status = array('message' => $chat['message'], 'status' => $chat['status']);
	$response['userstatus'] = $status;
}
function setStatus($message) {
	global $userid;
	$sql = ("insert into hfchat_status (userid,status) values ('".mysql_real_escape_string($userid)."','".mysql_real_escape_string(sanitize_core($message))."') on duplicate key update status = '".mysql_real_escape_string(sanitize_core($message))."'");
	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	if (function_exists('hooks_activityupdate')) {
		hooks_activityupdate($userid,$message);
	}
}
function getLastTimestamp() {
	if (empty($_POST['timestamp'])) {
		$_POST['timestamp'] = 0;
	}
	if ($_POST['timestamp'] == 0) {
		foreach ($_SESSION as $key => $value) {
			if (substr($key,0,15) == "hfchat_user_") {
				if (!empty($_SESSION[$key]) && is_array($_SESSION[$key])) {
					$temp = end($_SESSION[$key]);
					if ($_POST['timestamp'] < $temp['id']) {
						$_POST['timestamp'] = $temp['id'];
					}
				}
			}
		}
		if ($_POST['timestamp'] == 0) {
			$sql = ("select id from hfchat order by id desc limit 1");
			$query = mysql_query($sql);
			if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
			$chat = mysql_fetch_array($query);
			$_POST['timestamp'] = $chat['id'];
		}
	}
	
}
function fetchMessages() {
	global $response;
	global $userid;
	global $db;
	global $messages;
	$timestamp = 0;
	if (defined('USE_COMET') && USE_COMET == 1) { return; }
	$sql = ("select hfchat.id, hfchat.from, hfchat.to, hfchat.message, hfchat.sent, hfchat.read from hfchat where ((hfchat.to = '".mysql_real_escape_string($userid)."' and hfchat.direction <> 2) or (hfchat.from = '".mysql_real_escape_string($userid)."' and hfchat.direction <> 1)) and (hfchat.id > '".mysql_real_escape_string($_POST['timestamp'])."' or (hfchat.to = '".mysql_real_escape_string($userid)."' and hfchat.read != 1)) order by hfchat.id");
	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') {echo mysql_error(); }
	while ($chat = mysql_fetch_array($query)) {
		$self = 0;
		$old = 0;
		if ($chat['from'] == $userid) {
			$chat['from'] = $chat['to'];
			$self = 1;
			$old = 1;
		}
		if ($chat['read'] == 1) {
			$old = 1;
		}
		$messages[] = array('id' => $chat['id'], 'from' => $chat['from'], 'message' => $chat['message'], 'self' => $self, 'old' => $old, 'sent' => ($chat['sent']+$_SESSION['timedifference']));
		if ($self == 0 && $old == 0 && $chat['read'] != 1) {
			$_SESSION['hfchat_user_'.$chat['from']][] = array('id' => $chat['id'], 'from' => $chat['from'], 'message' => $chat['message'], 'self' => 0, 'old' => 1, 'sent' => ($chat['sent']+$_SESSION['timedifference']));
		}
		$timestamp = $chat['id'];
	}	
	if (!empty($messages)) {
		$sql = ("update hfchat set hfchat.read = '1' where hfchat.to = '".mysql_real_escape_string($userid)."' and hfchat.id <= '".mysql_real_escape_string($timestamp)."'");
		$query = mysql_query($sql);
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	}
}
function typingTo() {
	global $response;
	global $userid;
	global $db;
	global $messages;
	$timestamp = 0;
	if (defined('USE_COMET') && USE_COMET == 1) { return; }
	$sql = ("select GROUP_CONCAT(userid, ',') from hfchat_status where typingto = '".mysql_real_escape_string($userid)."' and ('".getTimeStamp()."'-typingtime < 10)");
	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	$chat = mysql_fetch_array($query);
	if (!empty($chat[0])) {
		$response['tt'] = $chat[0];
	} else {
		$response['tt'] = '';
	}
}
function checkAnnoucements() {
	global $response;
	global $userid;
	global $db;
	global $messages;
	global $cookiePrefix;
	$timestamp = 0;
	$sql = ("select id,announcement from hfchat_announcements where `to` = '0' or `to` = '-1' or `to` = '".mysql_real_escape_string($userid)."' order by id desc limit 1");
	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	$announcement = mysql_fetch_array($query);
	if (!empty($announcement[1]) && (empty($_COOKIE[$cookiePrefix.'an']) || (!empty($_COOKIE[$cookiePrefix.'an']) && $_COOKIE[$cookiePrefix.'an'] < $announcement[0]))) {
		$response['an'] = array('id' => $announcement[0], 'm' => $announcement[1]);
	}
}
if ($userid != 0) {
	if (!empty($_POST['chatbox'])) {
		getChatboxData($_POST['chatbox']);
	} else {
		if (!empty($_POST['buddylist']) && $_POST['buddylist'] == 1) { getBuddyList(); }
		if (!empty($_POST['initialize']) && $_POST['initialize'] == 1) { 
			$_SESSION['timedifference'] = round((($_POST['currenttime']-getTimeStamp())/60)/30)*60*30;
			if (defined('USE_COMET') && USE_COMET == 1) {
				$response['cometid']['id'] = md5($userid.KEY_A.KEY_B.KEY_C);
				$response['cometid']['td'] = $_SESSION['timedifference'];
				if (empty($_SESSION['cometmessagesafter'])) {
					$_SESSION['cometmessagesafter'] = getTimeStamp();
				}
				$response['initialize'] = 0;
			} else {
				$sql = ("select id from hfchat order by id desc limit 1");
				$query = mysql_query($sql);
				if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
				$result = mysql_fetch_array($query);
				$response['initialize'] = $result['id'];
			}
			getStatus(); 
			if (!empty($_COOKIE[$cookiePrefix.'state'])) {
				$states = explode(':',urldecode($_COOKIE[$cookiePrefix.'state']));
				$openChatboxId = '';
				if ($states[2] != '' && $states[2] != ' ') {
					$openChatboxId = $states[2];
				}
				getChatboxData($openChatboxId);
			}
		}
		if (!defined('USE_COMET') || (defined('USE_COMET') && USE_COMET == 0)) { getLastTimestamp(); }
		if (defined('DISABLE_ISTYPING') && DISABLE_ISTYPING != 1) { typingTo(); }
		if (defined('DISABLE_ANNOUNCEMENTS') && DISABLE_ANNOUNCEMENTS != 1) { checkAnnoucements(); }
		if (!empty($_POST['status'])) {
			setStatus($_POST['status']);
		}
		fetchMessages();
	}
	$sql = updateLastActivity($userid);
	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	if (!empty($_POST['typingto']) && $_POST['typingto'] != 0 && DISABLE_ISTYPING != 1) {
		$sql = ("insert into hfchat_status (userid,typingto,typingtime) values ('".mysql_real_escape_string($userid)."','".mysql_real_escape_string($_POST['typingto'])."','".getTimeStamp()."') on duplicate key update typingto = '".mysql_real_escape_string($_POST['typingto'])."', typingtime = '".getTimeStamp()."'");
		$query = mysql_query($sql);
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	}
} else {
	$response['loggedout'] = '1';
	if (DO_NOT_DESTROY_SESSION != 1) {
		session_destroy();
	}
}
if (!empty($messages)) {
	$response['messages'] = $messages;
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($response);
exit;
?>
