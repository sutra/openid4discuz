<?php
/**
 * @author sutra
 * @copyright Copyright &copy; 2001-2007, Redv Soft
 * @license http://openid4discuz.redv.com/LICENSE.txt BSD
 */
require_once "common.php";
include_once language('openid');
session_start();

function gotoRegOrBind($openid, $sreg) {
	global $_COOKIE, $cookiepre, $sid;

	updateOpenIDSession($sid, $openid);
	setcookie('openid4discuz_openid_sreg_nickname', $sreg['nickname']);
	setcookie('openid4discuz_openid_sreg_email', $sreg['email']);
	/*
	showmessage($GLOBALS['language']['openid_no_bind_before']
		.'<a href="'.$openid.'">'.$openid.'</a>'.$GLOBALS['language']['openid_no_bind_after'],
		'register.php');
	*/
	showmessage(
		"你的OpenID（<a href=\"$openid\">$openid</a>）尚未和任何论坛账号绑定。"
		."<br /><br />你可以将你的OpenID<a href=\"logging.php?action=login&amp;openid_action=bind\">"
		."和你已有的论坛账号绑定</a>或者<a href=\"register.php\">新注册一个论坛账号并绑定</a>。"
	);
}

function runDiscuz($openid, $sreg) {
	global $tablepre, $query, $db, $_DCACHE, $_DCOOKIE;

	global $discuz_uid, $discuz_user, $discuz_pw, $discuz_secques, $adminid, $groupid, $styleidmem, 
		$lastvisit, $lastpost, $allowinvisible;
	global $discuz_userss;

	$query = $db->query("SELECT uid, openid_url FROM {$tablepre}openid WHERE openid_url='".$openid."'");
	$member_openid = $db->fetch_array($query);
	if (!$member_openid['uid']) {
		gotoRegOrBind($openid, $sreg);
	} else {
		$uid = $member_openid['uid'];
		// set login start
		$query = $db->query("SELECT m.uid AS discuz_uid, m.username AS discuz_user, m.password AS discuz_pw, m.secques AS discuz_secques,
							m.adminid, m.groupid, m.styleid AS styleidmem, m.lastvisit, m.lastpost, u.allowinvisible
							FROM {$tablepre}members m LEFT JOIN {$tablepre}usergroups u USING (groupid)
							WHERE m.uid='" . $uid . "'");
		$member = $db->fetch_array($query);

		if ($member['discuz_uid']) {

			extract($member);

			$discuz_userss = $discuz_user;
			$discuz_user = addslashes($discuz_user);

//			if (($allowinvisible && $loginmode == 'invisible') || $loginmode == 'normal') {
//				$db->query("UPDATE {$tablepre}members SET invisible='" . ($loginmode == 'invisible' ? 1 : 0) . "' WHERE uid='$member[discuz_uid]'", 'UNBUFFERED');
//			}

			$styleid = intval(empty($_POST['styleid']) ? ($styleidmem ? $styleidmem :
					$_DCACHE['settings']['styleid']) : $_POST['styleid']);

			$cookietime = intval(isset($_POST['cookietime']) ? $_POST['cookietime'] :
					($_DCOOKIE['cookietime'] ? $_DCOOKIE['cookietime'] : 0));

			dsetcookie('cookietime', $cookietime, 31536000);
			dsetcookie('auth', authcode("$discuz_pw\t$discuz_secques\t$discuz_uid", 'ENCODE'), $cookietime);

			$sessionexists = 0;

			if ($groupid == 8) {
				showmessage('login_succeed_inactive_member', 'memcp.php');
			} else {
				showmessage('login_succeed', dreferer());
			}
		}
		// set login end
	}
}

function run() {
    $consumer = getConsumer();

    // Complete the authentication process using the server's
    // response.
    $return_to = getReturnTo('finish_auth');
    $response = $consumer->complete($return_to);

    // Check the response status.
    if ($response->status == Auth_OpenID_CANCEL) {
        // This means the authentication was cancelled.
        $msg = 'Verification cancelled.';
    } else if ($response->status == Auth_OpenID_FAILURE) {
        // Authentication failed; display the error message.
        $msg = "OpenID authentication failed: " . $response->message;
    } else if ($response->status == Auth_OpenID_SUCCESS) {
        // This means the authentication succeeded; extract the
        // identity URL and Simple Registration data (if it was
        // returned).
        $openid = $response->getDisplayIdentifier();
        $esc_identity = htmlspecialchars($openid, ENT_QUOTES);

        $success = sprintf('You have successfully verified ' .
                           '<a href="%s">%s</a> as your identity.',
                           $esc_identity, $esc_identity);

        if ($response->endpoint->canonicalID) {
            $success .= '  (XRI CanonicalID: '.$response->endpoint->canonicalID.') ';
        }

        $sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);

        $sreg = $sreg_resp->contents();

        if (@$sreg['email']) {
            $success .= "  You also returned '".$sreg['email']."' as your email.";
        }

        if (@$sreg['nickname']) {
            $success .= "  Your nickname is '".$sreg['nickname']."'.";
        }

        if (@$sreg['fullname']) {
            $success .= "  Your fullname is '".$sreg['fullname']."'.";
        }

	$pape_resp = Auth_OpenID_PAPE_Response::fromSuccessResponse($response);

	if ($pape_resp) {
	  if ($pape_resp->auth_policies) {
	    $success .= "<p>The following PAPE policies affected the authentication:</p><ul>";

	    foreach ($pape_resp->auth_policies as $uri) {
	      $success .= "<li><tt>$uri</tt></li>";
	    }

	    $success .= "</ul>";
	  } else {
	    $success .= "<p>No PAPE policies affected the authentication.</p>";
	  }

	  if ($pape_resp->auth_age) {
	    $success .= "<p>The authentication age returned by the " .
	      "server is: <tt>".$pape_resp->auth_age."</tt></p>";
	  }

	  if ($pape_resp->nist_auth_level) {
	    $success .= "<p>The NIST auth level returned by the " .
	      "server is: <tt>".$pape_resp->nist_auth_level."</tt></p>";
	  }

	} else {
	  $success .= "<p>No PAPE response was sent by the provider.</p>";
	}

		runDiscuz($openid, $sreg);
    }

    include 'message.php';
}

run();
?>