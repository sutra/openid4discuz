<?php
/*
 * Created on 2008-1-21
 */
/**
 * OpenID Session Data Access Object.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 */
define('OPENID4DISCUZ_DISCUZ_DAO_ROOT', dirname(__FILE__));
include_once (OPENID4DISCUZ_DISCUZ_DAO_ROOT . "/../OpenIDSessionDao.php");
include_once (OPENID4DISCUZ_DISCUZ_DAO_ROOT . "/DiscuzDao.php");

/**
 * @access public
 */
class DiscuzOpenIDSessionDao extends DiscuzDao implements OpenIDSessionDao {
	/**
	 * @access public
	 */
	public function DiscuzOpenIDSessionDao($tablepre, $db) {
		DiscuzDao::DiscuzDao($tablepre, $db);
	}

	/**
	 * @access public
	 */
	public function getOpenIDFromSession($sid) {
		$query = $this->db->query("SELECT openid_url as openid_identifier FROM {$this->tablepre}openid_sessions WHERE sid='" . $sid . "'");
		$arr = $this->db->fetch_array($query);
		return $arr['openid_identifier'];
	}

	/**
	 * @access public
	 */
	public function deleteOpenIDSession($sid) {
		$this->db->query("DELETE FROM {$this->tablepre}openid_sessions WHERE sid='" . $sid . "'");
	}

	/**
	 * @access public
	 */
	public function updateOpenIDSession($sid, $openid_identifier) {
		$this->db->query("DELETE FROM {$this->tablepre}openid_sessions WHERE sid = '" . $sid . "'");
		$this->db->query("INSERT INTO {$this->tablepre}openid_sessions(sid, openid_url) VALUES('" . $sid . "', '" . $openid_identifier . "')");
	}
}
?>