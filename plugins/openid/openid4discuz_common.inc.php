<?php
/*
 * Created on 2008-1-22
 */
/**
 * OpenID4Discuz common.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 * @access public
 */
define('OPENID4DISCUZ_ROOT', dirname(__FILE__));
define('OPENID4DISCUZ_DISCUZ_ROOT', dirname(dirname(dirname(__FILE__))));

// OpenID4Discuz utilities.
require_once OPENID4DISCUZ_ROOT.'/util/OpenID4DiscuzUtils.php';

// OpenID4Discuz manager.
require_once OPENID4DISCUZ_ROOT."/OpenID4Discuz.php";

// for php-openid.
require_once OPENID4DISCUZ_ROOT."/common.php";

$openid4discuz = new OpenID4Discuz($tablepre, $db);
?>
