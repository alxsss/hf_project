<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('SET_SESSION_NAME','hfchat');			// Session name
define('DO_NOT_START_SESSION','0');		// Set to 1 if you have already started the session
define('DO_NOT_DESTROY_SESSION','1');	// Set to 1 if you do not want to destroy session on logout
define('SWITCH_ENABLED','0');		
define('INCLUDE_JQUERY','0');	
define('FORCE_MAGIC_QUOTES','0');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */
/* DATABASE */
include_once(dirname(__FILE__)."/../../../../hemsinif/config/db_hfchat.php");
//include_once(dirname(__FILE__)."/../../config/db_hfchat.php");

define('DB_SERVER',                                     'localhost'                                                             );
define('DB_PORT',                                       '3306'                                                                  );
define('DB_USERNAME',                           'hemsinif'                                                                      );
define('DB_PASSWORD',                           $passwd);
define('DB_NAME',                                       'hemsinif'                                                              );
define('TABLE_PREFIX',                          ''                                                                              );
define('DB_USERTABLE',                          'sf_guard_user'                                                                 );
define('DB_USERTABLE_NAME',                     'username'                                                              );
define('DB_USERTABLE_USERID',           'id'                                                            );
define('DB_USERTABLE_LASTACTIVITY',     'last_login'                                                    );


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */
function getUserID() {
        $userid = 0;

        /*if (!empty($_SESSION['userid'])) {
                $userid = $_SESSION['userid'];
        }*/
     if (!empty($_COOKIE['hemsinifRememberMe'])) {
            $sql = ("select user_id from sf_guard_remember_key
            where remember_key = '".mysql_real_escape_string($_COOKIE['hemsinifRememberMe'])."'");
            $query = mysql_query($sql);
            $session = mysql_fetch_array($query);
            $userid = $session['user_id'];
        }

        return $userid;
}


function getFriendsList($userid,$time) {
        //$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." avatar, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link, hfchat_status.message, hfchat_status.status from ".TABLE_PREFIX."friends join ".TABLE_PREFIX.DB_USERTABLE." on  ".TABLE_PREFIX."friends.toid = ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." left join hfchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = hfchat_status.userid where ".TABLE_PREFIX."friends.fromid = '".mysql_real_escape_string($userid)."' order by username asc");
        /*$sql=("select DISTINCT sf_guard_user.id userid, sf_guard_user.username username,   UNIX_TIMESTAMP(sf_guard_user.last_login) lastactivity,  sf_guard_user.id avatar,  sf_guard_user.username link, hfchat_status.message,
        hfchat_status.status from sf_guard_user left join
         hfchat_status on sf_guard_user.id= hfchat_status.userid where sf_guard_user.id IN(select friend.friend_id as id from friend where friend.user_id='".mysql_real_escape_string($userid)."' and friend.approved=1
         UNION select friend.user_id as id from friend where friend.friend_id='".mysql_real_escape_string($userid)."' and friend.approved=1) ");*/


    $sql=("select DISTINCT sessions.user_id userid, sf_guard_user.username username,   UNIX_TIMESTAMP(sf_guard_user.last_login) lastactivity,
    sf_guard_user.id avatar,  sf_guard_user.username link, hfchat_status.message,
        hfchat_status.status from sessions left join sf_guard_user on sessions.user_id=sf_guard_user.id left join
        hfchat_status on sf_guard_user.id= hfchat_status.userid where sf_guard_user.id
        IN(select friend.friend_id as id from friend where friend.user_id='".mysql_real_escape_string($userid)."' and friend.approved=1
         UNION select friend.user_id as id from friend where friend.friend_id='".mysql_real_escape_string($userid)."' and friend.approved=1)
         and  sessions.sess_time>UNIX_TIMESTAMP(now())-300 order by sessions.sess_time desc");
        return $sql;
}
function getUserDetails($userid) {
        $sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, UNIX_TIMESTAMP(".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY.") lastactivity,  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link,  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." avatar, hfchat_status.message, hfchat_status.status from ".TABLE_PREFIX.DB_USERTABLE." left join hfchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = hfchat_status.userid where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
        return $sql;
}

function updateLastActivity($userid) {
        $sql = ("update `".TABLE_PREFIX.DB_USERTABLE."` set ".DB_USERTABLE_LASTACTIVITY." = now() where ".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
        return $sql;
}

function getUserStatus($userid) {
         $sql = ("select hfchat_status.message, hfchat_status.status from hfchat_status where userid = '".mysql_real_escape_string($userid)."'");
         return $sql;
}

function getLink($link) {
    return '/az/user/'.$link;
}

function getAvatar($image) {
    /*if (is_file(dirname(dirname(__FILE__)).'/images/'.$image.'.gif')) {
        return 'images/'.$image.'.gif';
    } else {
        return 'images/noavatar.gif';
    }*/

        $sql = ("select photo from sf_guard_user_profile
            where user_id = '".mysql_real_escape_string($image)."'");
            $query = mysql_query($sql);
            $avatar = mysql_fetch_array($query);
            $filename = $avatar['photo'];
                if (is_file(dirname(dirname(__FILE__)).'/uploads/assets/avatars/thumbnails/'.$filename))
                {
          return '/uploads/assets/avatars/thumbnails/'.$filename;
        }
                else
                {
        //return 'images/noavatar.gif';
                return '/uploads/assets/avatars/thumbnails/no_pic.gif';
    }
}

function getTimeStamp() {
        return time();
}

function processTime($time) {
	return $time;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* HOOKS */

function hooks_statusupdate($userid,$statusmessage) {
	
}

function hooks_forcefriends() {
	
}

function hooks_activityupdate($userid,$status) {

}

function hooks_message($userid,$unsanitizedmessage) {
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).'/license.php');
$x="\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
