<?php
/**
 * @author sutra
 * @copyright Copyright &copy; 2001-2007, Redv Soft
 * @license http://openid4discuz.redv.com/LICENSE.txt BSD
 */
require_once 'include/common.inc.php';
require_once DISCUZ_ROOT.'./plugins/openid/openid4discuz_common.inc.php';
require_once DISCUZ_ROOT.'./forumdata/cache/plugin_openid4discuz.php';

$action = $_GET['action'];
if ($action == 'finish_auth') {
	include 'plugins/openid/finish_auth.inc.php';
} elseif ($action == 'finish_auth_openid_setting') {
	include 'plugins/openid/finish_openid_setting.inc.php';
} else {
	if (empty($openid_identifier)) {
		showmessage('请输入OpenID。', dreferer());
	} else {
		include 'plugins/openid/try_auth.inc.php';
	}
}
?>