<?php
/*
 * Created on 2008-1-21
 */
/**
 * OpenID Username Cache Data Access Object.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 */
define('OPENID4DISCUZ_DISCUZ_DAO_ROOT', dirname(__FILE__));
include_once (OPENID4DISCUZ_DISCUZ_DAO_ROOT."/../OpenIDUsernameCacheDao.php");
include_once (OPENID4DISCUZ_DISCUZ_DAO_ROOT."/DiscuzDao.php");

/**
 * @access public
 */
class DiscuzOpenIDUsernameCacheDao extends DiscuzDao implements OpenIDUsernameCacheDao {
	/**
	 * @access public
	 */	
	function DiscuzOpenIDUsernameCacheDao($tablepre, $db) {
		DiscuzDao::DiscuzDao($tablepre, $db);
	}

	/**
	 * @access public
	 */
	function updateLastNumber($username, $last_number) {
		$this->db->query("UPDATE {$this->tablepre}openid_username_cache SET last_number = ".$last_number." WHERE username = '".$username."'");
	}

	/**
	 * @access private
	 */
	public function insertLastNumber($username, $last_number) {
		$this->db->query("INSERT INTO {$this->tablepre}openid_username_cache(username, last_number) VALUES('".$username."', ".$last_number.")");		
	}

	/**
	 * @access public
	 */
	public function getLastNumber($username) {
		$query = $this->db->query("SELECT last_number FROM {$this->tablepre}openid_username_cache WHERE username = '".$username."'");
		$rows = $this->db->affected_rows($query);
		if ($rows == 0)	{
			$this->insertLastNumber($username, 0);
			return 0;
		} else {
			$arr = $this->db->fetch_array($query);
			return $arr['last_number'];
		}
	}
}
?>
