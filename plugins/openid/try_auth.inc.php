<?php
/**
 * @author sutra
 * @copyright Copyright &copy; 2001-2007, Redv Soft
 * @license http://openid4discuz.redv.com/LICENSE.txt BSD
 */
require_once "openid4discuz_common.inc.php";
session_start();

tryAuth($openid_identifier, getReturnTo('finish_auth'));
?>