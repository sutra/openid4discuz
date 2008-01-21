<?php
/*
 * Created on 2008-1-22
 */
/**
 * OpenID4Discuz daos.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 * @access public
 */
define('OPENID4DISCUZ_ROOT', dirname(__FILE__));
include_once (OPENID4DISCUZ_ROOT . "/dao/discuz/DiscuzOpenIDDao.php");
include_once (OPENID4DISCUZ_ROOT . "/dao/discuz/DiscuzOpenIDSessionDao.php");
include_once (OPENID4DISCUZ_ROOT . "/dao/discuz/DiscuzOpenIDUsernameCacheDao.php");
include_once (OPENID4DISCUZ_ROOT . "/util/OpenIDIdentifierParser.php");

class OpenID4Discuz {
	private $openidDao;

	private $openidSessionDao;

	private $openidUsernameCacheDao;

	/**
	 * @access public
	 */
	public function OpenID4Discuz($tablepre, $db) {
		$this->openidDao = new DiscuzOpenIDDao($tablepre, $db);
		$this->openidSessionDao = new DiscuzOpenIDSessionDao($tablepre, $db);
		$this->openidUsernameCacheDao = new DiscuzOpenIDUsernameCacheDao($tablepre, $db);
	}
	
	/**
	 * Register.
	 * 
	 * @access public
	 */
	public function registerOpenID($sid, $uid) {
		$openid_identifier = $this->openidSessionDao->getOpenIDFromSession($sid);
		$this->openidSessionDao->deleteOpenIDSession($sid);
		if (!empty($openid_identifier)) {
			bindOpenID($uid, $openid_identifier);
		}	
	}

	/**
	 * Generate username.
	 * 
	 * @access public
	 */
	public function generateUsername($openid_identifier, $sreg = null) {
		$ret = null;

		$username = $this->obtainNickname($openid_identifier, $sreg);

		// Find the last number in the cache.
		$last_number = $this->openidUsernameCacheDao->getLastNumber($username);
	
		if ($last_number == 0 && !$this->openidDao->isUsernameExists($username)) {
			$ret = $username;
		}

		if ($ret == null) {
			$last_number = $this->openidDao->findNextNumber($username, $last_number);
			$ret = $username.$last_number;
		}

		// Update username cache.
		$this->openidUsernameCacheDao->updateLastNumber($username, $last_number);	

		return $ret;
	}

	/**
	 * @access private
	 */
	private function obtainNickname($openid_identifier, $sreg) {
		$ret = null;
		if (!empty($sreg['nickname'])) {
			$ret = $sreg['nickname'];
		} elseif (!empty($sreg['email'])) {
			$a = preg_split("/[@]/", $sreg['email']);
			$ret = $a[0];
		} else {
			$ret = OpenIDIdentifierParser::parseNicknameFromUrl($openid_identifier);
		}
		return strtolower($ret);
	}
}
?>
