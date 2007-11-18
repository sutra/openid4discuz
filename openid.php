<?php
define('NOROBOT', TRUE);
define('CURSCRIPT', 'logging');

require_once './include/common.inc.php';
require_once DISCUZ_ROOT . './include/misc.func.php';

include_once language('openid');

require_once DISCUZ_ROOT . './plugins/openid/openid.func.php';
require_once DISCUZ_ROOT . './plugins/openid/class.openid.php';

$this_url = "openid.php";
$login_page = "logging.php?action=login";

if ($_GET['openid_mode'] == 'id_res') { // Perform HTTP Request to OpenID server to validate key
	$openid = new SimpleOpenID;
	$openid->SetIdentity($_GET['openid_identity']);
	$openid_validation_result = $openid->ValidateWithServer();
	if ($openid_validation_result == true) { // OK HERE KEY IS VALID
		$query = $db->query("SELECT uid, openid_url FROM {$tablepre}openid WHERE openid_url='" . $openid->GetIdentity() . "'");
		$member_openid = $db->fetch_array($query);
		// echo $member_openid['uid'];
		if (!$member_openid['uid']) {
			showmessage($GLOBALS['language']['openid_no_bind_before'] . '<a href="' . $openid->GetIdentity() . '">' . $openid->GetIdentity() . '</a>' . $GLOBALS['language']['openid_no_bind_after'], $login_page);
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

				if (($allowinvisible && $loginmode == 'invisible') || $loginmode == 'normal') {
					$db->query("UPDATE {$tablepre}members SET invisible='" . ($loginmode == 'invisible' ? 1 : 0) . "' WHERE uid='$member[discuz_uid]'", 'UNBUFFERED');
				}

				$styleid = intval(empty ($_POST['styleid']) ? ($styleidmem ? $styleidmem : $_DCACHE['settings']['styleid']) : $_POST['styleid']);

				$cookietime = intval(isset ($_POST['cookietime']) ? $_POST['cookietime'] : ($_DCOOKIE['cookietime'] ? $_DCOOKIE['cookietime'] : 0));

				dsetcookie('cookietime', $cookietime, 31536000);
				dsetcookie('auth', authcode("$discuz_pw\t$discuz_secques\t$discuz_uid", 'ENCODE'), $cookietime);

				$sessionexists = 0;

				if ($passport_status == 'shopex' && $passport_shopex) {
					if ($groupid == 8) {
						$verify = md5('loginmemcp.php' . $passport_key);
						showmessage('login_succeed_inactive_member', 'api/relateshopex.php?action=login&forward=memcp.php&verify=' . $verify);
					} else {
						$dreferer = dreferer();
						$verify = md5('login' . $dreferer . $passport_key);
						showmessage('login_succeed', 'api/relateshopex.php?action=login&forward=' . rawurlencode($dreferer) . '&verify=' . $verify);
					}
				} else {
					if ($groupid == 8) {
						showmessage('login_succeed_inactive_member', 'memcp.php');
					} else {
						showmessage('login_succeed', dreferer());
					}
				}
			}
			// set login end
		}
	} else
		if ($openid->IsError() == true) { // ON THE WAY, WE GOT SOME ERROR
			$error = $openid->GetError();
			showmessage($error['description'] . "(" . $error['code'] . ")", $login_page);
		} else { // Signature Verification Failed
			showmessage("INVALID AUTHORIZATION", $login_page);
		}
} else
	if ($_GET['openid_mode'] == 'cancel') { // User Canceled your Request
		echo "USER CANCELED REQUEST";
	} else {
		$openid = new SimpleOpenID;
		$openid->SetIdentity($openid_url);
		$openid->SetTrustRoot('http://' . $_SERVER["HTTP_HOST"]);
		if ($openid->GetOpenIDServer()) {
			$openid->SetApprovedURL(getUrl()); // Send Response from OpenID server to this script
			$openid->Redirect(); // This will redirect user to OpenID Server
		} else {
			$error = $openid->GetError();
			showmessage($error['description'] . "(" . $error['code'] . ")", $login_page);
		}
		exit;
	}
?>