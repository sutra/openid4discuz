<?php
define('NOROBOT', TRUE);
define('CURSCRIPT', 'openid_install');

require_once './include/common.inc.php';

include_once language('openid_install');

include template('openid_install');
?>