<?php
if(!$discuz_uid) {
		showmessage('请您登陆后访问本站，现在将转入登录页面。', 'logging.php?action=login');
}

require_once DISCUZ_ROOT.'./plugins/openid/class.openid.php';


// EXAMPLE
if($_GET['openid_mode'] == 'id_res'){ 	// Perform HTTP Request to OpenID server to validate key
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
}else if($_POST['openid_url']){
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
		echo "ERROR CODE: " . $error['code'] . "<br>";
		echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
	}
	exit;
}


include template('openid-setting');
?>