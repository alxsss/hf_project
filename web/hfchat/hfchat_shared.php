<?php
function sanitize($text) {
	global $smileys;

	$text = sanitize_core($text);
	$text = $text." ";
	$text = str_replace('&amp;','&',$text);

	$search  = "/(((\S+\@)|(?#Protocol)(?:(?:ht|f)tp(?:s?)\:\/\/|~\/|\/)?(?#Username:Password)(?:\w+:\w+@)?)(?#Subdomains)(?:(?:[-\w]+\.)+(?#TopLevel Domains)(?:com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum|travel|a[cdefgilmnoqrstuwz]|b[abdefghijmnorstvwyz]|c[acdfghiklmnoruvxyz]|d[ejkmnoz]|e[ceghrst]|f[ijkmnor]|g[abdefghilmnpqrstuwy]|h[kmnrtu]|i[delmnoqrst]|j[emop]|k[eghimnprwyz]|l[abcikrstuvy]|m[acdghklmnopqrstuvwxyz]|n[acefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eouw]|s[abcdeghijklmnortuvyz]|t[cdfghjkmnoprtvwz]|u[augkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw]|aero|arpa|biz|com|coop|edu|info|int|gov|mil|museum|name|net|org|pro))(?#Port)(?::[\d]{1,5})?(?#Directories)(?:(?:(?:\/(?:[-\w~!$+|.,=]|%[a-f\d]{2})+)+|\/)+|#)?(?#Query)(?:(?:\?(?:[-\w~!$+|.,*:]|%[a-f\d{2}])+=?(?:[-\w~!$+|.,*:=]|%[a-f\d]{2})*)(?:&(?:[-\w~!$+|.,*:]|%[a-f\d{2}])+=?(?:[-\w~!$+|.,*:=]|%[a-f\d]{2})*)*)*(?#Anchor)(?:#(?:[-\w~!$+|.,*:=]|%[a-f\d]{2})*)?)([^[:alpha:]]|\?)/i";
	
	if (DISABLE_LINKING != 1) { 
		$text = preg_replace_callback($search, "autolink", $text);  
	}

	if (DISABLE_SMILEYS != 1) { 
		foreach ($smileys as $pattern => $result) {
			$text = str_ireplace($pattern,'<img class="hfchat_smiley" height="16" width="16" src="'.BASE_URL.'images/smileys/'.$result.'" alt="'.$pattern.'">',$text);
		}
	}

	return trim($text);
}

function sanitize_core($text) {
	global $bannedWords;
	$text = htmlspecialchars($text, ENT_NOQUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n"," <br> ",$text);

	for ($i=0;$i < count($bannedWords);$i++){ 
		$text = str_ireplace($bannedWords[$i],$bannedWords[$i][0].str_repeat("*",strlen($bannedWords[$i])-1),$text);      
	}

	return $text;
}

function autolink($matches) {

	$link = $matches[1];

	if (preg_match("/\@/",$matches[1])) {
		$text = "<a href=\"mailto: {$link}\">{$matches[0]}</a>"; 
	} else {
		if (!preg_match("/(file|gopher|news|nntp|telnet|http|ftp|https|ftps|sftp):\/\//",$matches[1])) {
			$link = "http://".$matches[1];
		}

		if (DISABLE_YOUTUBE != 1 && preg_match('#(?:<\>]+href=\")?(?:http://)?((?:[a-zA-Z]{1,4}\.)?youtube.com/(?:watch)?\?v=(.{11}?))[^"]*(?:\"[^\<\>]*>)?([^\<\>]*)(?:)?#',$link,$match)) {
			
			/* 
			
			// Bandwidth intensive function to fetch details about the YouTube video

			$contents = file_get_contents("http://gdata.youtube.com/feeds/api/videos/{$match[2]}?alt=json");

			$data = json_decode($contents);
			$title = $data->entry->title->{'$t'};

			if (strlen($title) > 50) {
				$title = substr($title,0,50)."...";
			}

			$description = substr($data->entry->content->{'$t'},0,100);
			$length = sec2hms($data->entry->{'media$group'}->{'yt$duration'}->seconds);
			$rating = $data->entry->{'gd$rating'}->average; 
			
			*/

			$text = '<a href="'.$link.'" target="_blank">'.$link.'</a><br/><a href="'.$link.'" target="_blank" style="display:inline-block;margin-bottom:3px;margin-top:3px;"><img src="http://img.youtube.com/vi/'.$match[2].'/default.jpg" border="0" style="padding:0px;display: inline-block; width: 120px;height:90px;">
			<div style="margin-top:-30px;text-align: right;width:110px;margin-bottom:10px;">
			<img height="20" border="0" width="20" style="opacity: 0.88;" src="'.BASE_URL.'images/play.gif"/>
			</div></a>'; 

		} else {
			$text = $matches[1];

			if (strlen($matches[1]) > 30) {
				$left = substr($matches[1],0,22);
				$right = substr($matches[1],-5);
				$matches[1] = $left."...".$right;		
			}

			$text = "<a href=\"{$link}\" target=\"_blank\" title=\"{$text}\">{$matches[1]}</a>$matches[2]"; 
		}
	}


	return $text;
}


function sec2hms ($sec, $padHours = true) {
	$hms = "";
	$hours = intval(intval($sec) / 3600); 
	if ($hours != 0) {
		$hms .= ($padHours) ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':' : $hours. ':';
	}

	$minutes = intval(($sec / 60) % 60); 
	$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
	$seconds = intval($sec % 60); 
	$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	return $hms;
}

function sendMessageTo($to,$message) {
	global $userid;

	if (!empty($to) && !empty($message)) {
		if ($userid != '') {

			if (defined('USE_COMET') && USE_COMET == 1) {
				
				$comet = new Comet(KEY_A,KEY_B);
				$info = $comet->publish(array(
					'channel' => md5($to.KEY_A.KEY_B.KEY_C),
					'message' => array ( "from" => $userid, "message" => ($message), "sent" => getTimeStamp(), "self" => 0)
				));

			} else {

				$sql = ("insert into hfchat (hfchat.from,hfchat.to,hfchat.message,hfchat.sent,hfchat.read,hfchat.direction) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."','".getTimeStamp()."',0,1)");
				$query = mysql_query($sql);
				if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

			}
		}
	}
}

function sendSelfMessage($to,$message,$sessionMessage = '') {
	global $userid;

	if (!empty($to) && !empty($message)) {
		if ($userid != '') {

			if (defined('USE_COMET') && USE_COMET == 1) {
				
				$comet = new Comet(KEY_A,KEY_B);
				$info = $comet->publish(array(
					'channel' => md5($userid.KEY_A.KEY_B.KEY_C),
					'message' => array ( "from" => $to, "message" => ($message), "sent" => getTimeStamp(), "self" => 1)
				));

				$insertedid = getTimeStamp().rand(0,1000000);

			} else {

				$sql = ("insert into hfchat (hfchat.from,hfchat.to,hfchat.message,hfchat.sent,hfchat.read, hfchat.direction) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."','".getTimeStamp()."',0,2)");
				$query = mysql_query($sql);
				if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

				$insertedid = mysql_insert_id();

				if (empty($_SESSION['hfchat_user_'.$to])) {
					$_SESSION['hfchat_user_'.$to] = array();
				}

				if (empty($sessionMessage)) {
					$sessionMessage = $message;
				}
				
				$_SESSION['hfchat_user_'.$to][] = array("id" => $insertedid, "from" => $to, "message" => $sessionMessage, "self" => 1, "old" => 1, 'sent' => (getTimeStamp()+$_SESSION['timedifference']));

			}
		
		}
	}
}

function sendAnnouncement($to,$message) {
	global $userid;

	if (!empty($to) && !empty($message)) {
		$sql = ("insert into hfchat_announcements (announcement,time,`to`) values ('".mysql_real_escape_string($message)."', '".getTimeStamp()."','".mysql_real_escape_string($to)."')");
		$query = mysql_query($sql);
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
	}
}

function getChatboxData($id) {
	global $messages;
	global $userid;

	if (!empty($id) && defined('USE_COMET') && USE_COMET == 1) {
		
		if (!empty($_SESSION['cometmessagesafter'])) {

			$comet = new Comet(KEY_A,KEY_B);
			$history = $comet->history(array(
			  'channel' => md5($userid.KEY_A.KEY_B.KEY_C),
			  'limit'   => COMET_HISTORY_LIMIT  
			));

			if (!empty($_SESSION['hfchat_user_'.$id])) {
				$messages = array_merge($messages,$_SESSION['hfchat_user_'.$id]);
			}

			$moremessages = array();

			$messagesafter = $_SESSION['cometmessagesafter'];

			if (!empty($_SESSION['hfchat_user_'.$id.'_clear']) && $_SESSION['hfchat_user_'.$id.'_clear'] > $_SESSION['cometmessagesafter']) {
				$messagesafter = $_SESSION['hfchat_user_'.$id.'_clear'];
			}

			foreach ($history as $message) {
				if ($message['from'] == $id && $message['sent'] >= $messagesafter) {
					$moremessages[] = array("id" => $message['sent'].rand(0,1000000), "from" => $message['from'], "message" => $message['message'], "self" => $message['self'], "old" => 1, 'sent' => ($message['sent']+$_SESSION['timedifference']));
				}
			}

			$messages = array_merge($messages,$moremessages);

			usort($messages, 'comparetime');
		
		}

	} else {
		if (!empty($id) && !empty($_SESSION['hfchat_user_'.$id])) {
			$messages = array_merge($messages,$_SESSION['hfchat_user_'.$id]);
		}
	}
}
function print_r_error_log($variable, $description = '') {
	ob_start();
	echo("\n\n$description\n");
	print_r($variable);
	$out = ob_get_contents();
	ob_end_clean();
	error_log($out);
}
function comparetime($a, $b) { return strnatcmp($a['sent'], $b['sent']); } 
