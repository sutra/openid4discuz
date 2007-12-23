var OPENID4DISCUZ_COOKIE_EXPIRES = new Date();
OPENID4DISCUZ_COOKIE_EXPIRES.setTime(OPENID4DISCUZ_COOKIE_EXPIRES.getTime() + 365 * (24 * 60 * 60 * 1000)); //+365 day

var OPENID4DISCUZ_OPENID_IDENTIFIER_COOKIE_NAME = "openid4discuz_cookie_openid_identifier";

function setOpenIdLogin(isOpenIdLogin) {
	document.getElementById("username").style.display = (isOpenIdLogin ? "none" : "inline");
	document.getElementById("openid_identifier").style.display = (isOpenIdLogin ? "inline" : "none");
	document.getElementById("password").disabled = isOpenIdLogin;
	document.getElementById("password").style.backgroundColor = isOpenIdLogin ? '#eee' : '';
	document.getElementById("questionid").disabled = isOpenIdLogin;
	document.getElementById("answer").disabled = isOpenIdLogin;
	document.getElementById("answer").style.backgroundColor = isOpenIdLogin ? '#eee' : '';
	
	if (isOpenIdLogin) {
		document.getElementById("openid_identifier").focus();
	} else {
		document.getElementById("username").focus();
	}

	setCookie("loginfield_openid", isOpenIdLogin, OPENID4DISCUZ_COOKIE_EXPIRES);
}

function submitLogin() {
	setCookie(OPENID4DISCUZ_OPENID_IDENTIFIER_COOKIE_NAME,
		document.getElementById("openid_identifier").value, OPENID4DISCUZ_COOKIE_EXPIRES);
}

function setOpenIDIdentifierFromCookie() {
	var argv = setOpenIDIdentifierFromCookie.arguments;
	var argc = setOpenIDIdentifierFromCookie.arguments.length;
	var textboxId = (argc > 0) ? argv[0] : "openid_identifier";

	var openid_identifier_in_cookie = getCookie(OPENID4DISCUZ_OPENID_IDENTIFIER_COOKIE_NAME);
	if (openid_identifier_in_cookie != null && openid_identifier_in_cookie != "") {
		document.getElementById(textboxId).value = openid_identifier_in_cookie;
	}
}