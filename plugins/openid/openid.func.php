<?php
function get_ip() {
	if ($_SERVER) {
		if ($_SERVER[HTTP_X_FORWARDED_FOR]) {
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif ($_SERVER["HTTP_CLIENT_ip"]) {
			$realip = $_SERVER["HTTP_CLIENT_ip"];
		} else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}

	} else {
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$realip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_CLIENT_ip')) {
			$realip = getenv('HTTP_CLIENT_ip');
		} else {
			$realip = getenv('REMOTE_ADDR');
		}
	}
	return $realip;
}

function getUrl() {
	$url = "http://" . $_SERVER["HTTP_HOST"];

	if (isset ($_SERVER["REQUEST_URI"])) {
		$url .= $_SERVER["REQUEST_URI"];
	} else {
		$url .= $_SERVER["PHP_SELF"];
		if (!empty ($_SERVER["QUERY_STRING"])) {
			$url .= "?" . $_SERVER["QUERY_STRING"];
		}
	}

	return $url;
}
?>