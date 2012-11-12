<?php
include_once dirname(__FILE__).'/hfchat_init.php';

if (!empty($_POST['status'])) {
	$message = $_POST['status'];
	$sql = ("insert into hfchat_status (userid,status) values ('".mysql_real_escape_string($userid)."','".mysql_real_escape_string(sanitize_core($message))."') on duplicate key update status = '".mysql_real_escape_string(sanitize_core($message))."'");
	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	if ($message == 'offline') {
		$_SESSION['hfchat_sessionvars']['buddylist'] = 0;
	}
	if (function_exists('hooks_activityupdate')) {
		hooks_activityupdate($userid,$message);
	}
	echo "1";
	exit(0);
}
if (!empty($_POST['statusmessage'])) {
	$message = $_POST['statusmessage'];
	$sql = ("insert into hfchat_status (userid,message) values ('".mysql_real_escape_string($userid)."','".mysql_real_escape_string(sanitize_core($message))."') on duplicate key update message = '".mysql_real_escape_string(sanitize_core($message))."'");
	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	if (function_exists('hooks_statusupdate')) {
		hooks_statusupdate($userid,$message);
	}
	echo "1";
	exit(0);
}
if (!empty($_POST['to']) && !empty($_POST['message'])) {
	$to = $_POST['to'];
	$message = $_POST['message'];
	if ($userid != '') {
		if (function_exists('hooks_message')) {
			hooks_message($userid,$to,$message);
		}
		if (!in_array($userid,$bannedUserIDs)) {
			if (defined('USE_COMET') && USE_COMET == 1) {
				$comet = new Comet(KEY_A,KEY_B);
				$info = $comet->publish(array(
					'channel' => md5($to.KEY_A.KEY_B.KEY_C),
					'message' => array ( "from" => $userid, "message" => sanitize($message), "sent" => getTimeStamp(), "self" => 0)
				));
				$insertedid = getTimeStamp().rand(0,1000000);
				if (defined('SAVE_LOGS') && SAVE_LOGS == 1) {
					$sql = ("insert into hfchat (hfchat.from,hfchat.to,hfchat.message,hfchat.sent,hfchat.read) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string(sanitize($message))."','".getTimeStamp()."',1)");
					$query = mysql_query($sql);
					$insertedid = mysql_insert_id();
				}
			} else {
				$sql = ("insert into hfchat (hfchat.from,hfchat.to,hfchat.message,hfchat.sent,hfchat.read) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string(sanitize($message))."','".getTimeStamp()."',0)");
				$query = mysql_query($sql);
				$insertedid = mysql_insert_id();
				if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
				if (empty($_SESSION['hfchat_user_'.$to])) {
					$_SESSION['hfchat_user_'.$to] = array();
				}
			}
			$_SESSION['hfchat_user_'.$to][] = array("id" => $insertedid, "from" => $to, "message" => sanitize($message), "self" => 1, "old" => 1, 'sent' => (getTimeStamp()+$_SESSION['timedifference']));
			echo $insertedid;
		} else {
			$sql = ("insert into hfchat (hfchat.from,hfchat.to,hfchat.message,hfchat.sent,hfchat.read,hfchat.direction) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string(sanitize($bannedMessage))."','".getTimeStamp()."',0,2)");
			$query = mysql_query($sql);
			if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
		}
	}
	exit(0);
}
?>
