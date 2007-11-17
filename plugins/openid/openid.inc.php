<?php
if(!$discuz_uid) {
	showmessage('请您登陆后访问本站，现在将转入登录页面。', 'logging.php?action=login');
}

require_once DISCUZ_ROOT.'./plugins/openid/class.openid.php';

if($_POST['formhash'] != '' && $_POST['openid_url'] == '') {	
	// Remove the binding between member account and openid
	//$query=$db->query("SELECT count(*) FROM {$tablepre}openid WHERE uid =".$discuz_uid);
	$query = $db->query("DELETE FROM {$tablepre}openid WHERE uid = ".$discuz_uid);
	$rows = $db->affected_rows($query);
	if ($rows) {
		showmessage('已删除你的账号和 OpenID 之间的绑定。', 'plugin.php?identifier=openid4discuz&module=openid');
	} else {
		showmessage('你的账号尚未绑定任何 OpenID。', 'plugin.php?identifier=openid4discuz&module=openid');
	}
} else if($_POST['formhash'] != '' && $_POST['openid_url'] != '') {
	// Redirect user to OpenID Server
	$openid = new SimpleOpenID;
	$openid->SetIdentity($openid_url);
	$openid->SetTrustRoot('http://' . $_SERVER["HTTP_HOST"]);
	$openid->SetRequiredFields(array('email','fullname'));
	$openid->SetOptionalFields(array('dob','gender','postcode','country','language','timezone'));
	if ($openid->GetOpenIDServer()){
		$openid->SetApprovedURL('http://' . $_SERVER["HTTP_HOST"] .'/discuz/plugin.php?identifier=openid4discuz&module=openid'. $_SERVER["PATH_INFO"]);  	// Send Response from OpenID server to this script
		$openid->Redirect(); 	// This will redirect user to OpenID Server
	}else{
		$error = $openid->GetError();
		// echo "ERROR CODE: " . $error['code'] . "<br>";
		// echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
		showmessage($error['description']."(".$error['code'].")", 'plugin.php?identifier=openid4discuz&module=openid');
	}
	exit;
} else if($_GET['openid_mode'] == 'id_res'){
	// Perform HTTP Request to OpenID server to validate key
	$openid = new SimpleOpenID;
	$openid->SetIdentity($_GET['openid_identity']);
	$openid_validation_result = $openid->ValidateWithServer();
	if ($openid_validation_result == true){ 		// OK HERE KEY IS VALID
		echo "VALID";
		echo $openid->GetIdentity();
		$query = $db->query("SELECT uid, openid_url FROM {$tablepre}openid WHERE uid = ".$discuz_uid);
		$member_openid = $db->fetch_array($query);
		// echo $member_openid['uid'];

		if ($member_openid['uid']) {
			$db->query("UPDATE {$tablepre}openid SET openid_url = '".$openid->GetIdentity()."' WHERE uid = ".$member_openid['uid']);
		} else {
			$db->query("INSERT {$tablepre}openid(uid, openid_url) VALUES(".$discuz_uid.", '".$openid->GetIdentity()."')");
		}
		
	}else if($openid->IsError() == true){			// ON THE WAY, WE GOT SOME ERROR
		$error = $openid->GetError();
		echo "ERROR CODE: " . $error['code'] . "<br>";
		echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
	}else{											// Signature Verification Failed
		echo "INVALID AUTHORIZATION";
	}
}else if ($_GET['openid_mode'] == 'cancel'){ // User Canceled your Request
	echo "USER CANCELED REQUEST";
}

// Obtain current binding from datbase to display
$query = $db->query("SELECT openid_url FROM {$tablepre}openid WHERE uid = ".$discuz_uid);
$openid = $db->fetch_array($query);

include template('openid-setting');
?>