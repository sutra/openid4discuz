<?php
/*
 * Created on 2008-1-21
 */
/**
 * OpenID Data Access Object.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 */
define('OPENID4DISCUZ_DISCUZ_DAO_ROOT', dirname(__FILE__));
include_once (OPENID4DISCUZ_DISCUZ_DAO_ROOT."/../OpenIDDao.php");
include_once (OPENID4DISCUZ_DISCUZ_DAO_ROOT."/DiscuzDao.php");

/**
 * @access public
 */
class DiscuzOpenIDDao extends DiscuzDao implements OpenIDDao {
	/**
	 * @access public
	 */
	function DiscuzOpenIDDao($tablepre, $db) {
		DiscuzDao::DiscuzDao($tablepre, $db);
	}

	/**
	 * @access public
	 */
	function bindOpenID($uid, $openid_identifier) {
		$this->db->query("INSERT {$this->tablepre}openid(uid, openid_url) VALUES('" . $uid . "', '" . $openid_identifier . "')");
	}

	/**
	 * @access public
	 */
	function unbindOpenID($uid, $openid_identifier) {
		$query = $this->db->query("DELETE FROM {$this->tablepre}openid WHERE uid = " . $uid);
		$rows = $this->db->affected_rows($query);
		return $rows;
	}
}
?>