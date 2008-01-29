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
require_once (OPENID4DISCUZ_DISCUZ_DAO_ROOT."/../OpenIDDao.php");
require_once (OPENID4DISCUZ_DISCUZ_DAO_ROOT."/DiscuzDao.php");

/**
 * @access public
 */
class DiscuzOpenIDDao extends DiscuzDao implements OpenIDDao {
	/**
	 * @access public
	 */
	public function DiscuzOpenIDDao($tablepre, $db) {
		DiscuzDao::DiscuzDao($tablepre, $db);
	}

	/**
	 * @access public
	 */
	public function getUserIDByOpenID($openid_identifier) {
		$query = $this->db->query("SELECT uid FROM {$this->tablepre}openid WHERE openid_url='" . $openid_identifier . "'");
		$member = $this->db->fetch_array($query);
		$uid = $member['uid'];
		if (!$uid) {
			return 0;
		} else {
			return $uid;
		}
	}

	/**
	 * @access public
	 */
	public function isUsernameExists($username) {
		$query = $this->db->query("SELECT username FROM {$this->tablepre}members WHERE username = '$username'");
		if($this->db->num_rows($query)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Find next number from the member table.
	 * 
	 * @access private
	 */
	public function findNextNumber($username, $number) {
		do {
			$number += 1;
			$query = $this->db->query("SELECT username FROM {$this->tablepre}members WHERE username = '$username$number'");
		} while ($this->db->num_rows($query));
		return $number;
	}

	/**
	 * @access public
	 */
	public function bindOpenID($uid, $openid_identifier) {
		$this->db->query("INSERT {$this->tablepre}openid(uid, openid_url) VALUES('" . $uid . "', '" . $openid_identifier . "')");
	}

	/**
	 * @access public
	 */
	public function unbindOpenID($uid, $openid_identifier) {
		$query = $this->db->query("DELETE FROM {$this->tablepre}openid WHERE uid = " . $uid);
		$rows = $this->db->affected_rows($query);
		return $rows;
	}
}
?>