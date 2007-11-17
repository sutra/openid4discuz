<?php
if (!$discuz_uid) {
	showmessage('请您登陆后访问本站，现在将转入登录页面。', 'logging.php?action=login');
}

require_once DISCUZ_ROOT.'./plugins/openid/openid.func.php';
require_once DISCUZ_ROOT . './plugins/openid/class.openid.php';

$this_url = 'plugin.php?identifier=openid4discuz&module=openidsetting';

if ($_POST['formhash'] != '' && $_POST['openid_url'] == '') {
	// Remove the binding between member account and openid
	//$query=$db->query("SELECT count(*) FROM {$tablepre}openid WHERE uid =".$discuz_uid);
	$query = $db->query("DELETE FROM {$tablepre}openid WHERE uid = " . $discuz_uid);
	$rows = $db->affected_rows($query);
	if ($rows) {
		showmessage('已删除你的账号和 OpenID 之间的绑定。', $this_url);
	} else {
		showmessage('你的账号尚未绑定任何 OpenID。', $this_url);
	}
}
elseif ($_POST['formhash'] != '' && $_POST['openid_url'] != '') {
	// Redirect user to OpenID Server
	$openid = new SimpleOpenID;
	$openid->SetIdentity($openid_url);
	$openid->SetTrustRoot('http://' . $_SERVER["HTTP_HOST"]);
	if ($openid->GetOpenIDServer()) {
		$openid->SetApprovedURL(getUrl()); // Send Response from OpenID server to this script
		$openid->Redirect(); // This will redirect user to OpenID Server
	} else {
		$error = $openid->GetError();
		showmessage($error['description'] . "(" . $error['code'] . ")", $this_url);
	}
	exit;
}
elseif ($_GET['openid_mode'] == 'id_res') {
	// Perform HTTP Request to OpenID server to validate key
	$openid = new SimpleOpenID;
	$openid->SetIdentity($_GET['openid_identity']);
	$openid_validation_result = $openid->ValidateWithServer();
	if ($openid_validation_result == true) { // OK HERE KEY IS VALID
		$query = $db->query("SELECT openid_url FROM {$tablepre}openid WHERE uid=" . $discuz_uid);
		$old_openid = $db->fetch_array($query);
		if (!$old_openid['openid_url']) {
			$db->query("INSERT {$tablepre}openid(uid, openid_url) VALUES(" . $discuz_uid . ", '" . $openid->GetIdentity() . "')");
			showmessage('你的账号和 OpenID（<a href="' . $openid->GetIdentity() . '">' . $openid->GetIdentity() . '</a>）已建立绑定，你现在可以使用 OpenID 来登录论坛了。', $this_url);
		}
		elseif ($old_openid['openid_url'] != $openid->GetIdentity()) {
			$query = $db->query("UPDATE {$tablepre}openid SET openid_url = '" . $openid->GetIdentity() . "' WHERE uid = " . $discuz_uid);
			showmessage('你的账号和 OpenID（<a href="' . $openid->GetIdentity() . '">' . $openid->GetIdentity() . '</a>）之间的关联已更新，你现在可以使用新的 OpenID 来登录论坛了。', $this_url);
		} else {
			showmessage("你没有修改 OpenID，请继续使用“<a href='" . $old_openid['openid_url'] . "'>" . $old_openid['openid_url'] . "</a>”登录。", $this_url);
		}
	}
	elseif ($openid->IsError() == true) { // ON THE WAY, WE GOT SOME ERROR
		$error = $openid->GetError();
		showmessage($error['description'] . "(" . $error['code'] . ")", $this_url);
	} else { // Signature Verification Failed
		showmessage("INVALID AUTHORIZATION", $this_url);
	}
}
elseif ($_GET['openid_mode'] == 'cancel') { // User Canceled your Request
	echo "USER CANCELED REQUEST";
}

// Obtain current binding from datbase to display
$query = $db->query("SELECT openid_url FROM {$tablepre}openid WHERE uid = " . $discuz_uid);
$openid = $db->fetch_array($query);

include template('openid-setting');
?>