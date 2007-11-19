<?php
define('NOROBOT', TRUE);
define('CURSCRIPT', 'openid_install');

require_once './include/common.inc.php';

include_once language('openid_install');

if ($_POST["installsubmit"]) {
	$sql = "CREATE TABLE IF NOT EXISTS `{$tablepre}openid` (" 
		. "`uid` mediumint(8) unsigned NOT NULL," 
		. "`openid_url` char(255) NOT NULL," 
		. "PRIMARY KEY (`openid_url`)," 
		. "UNIQUE KEY `uid` (`uid`)" 
		. ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	$db->query($sql);
}

include template('openid_install');
?>