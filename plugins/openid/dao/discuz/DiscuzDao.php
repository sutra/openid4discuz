<?php
/*
 * Created on 2008-1-21
 */
/**
 * Discuz Abstract Data Access Object.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 * @abstract
 * @access public
 */
abstract class DiscuzDao {
	protected $tablepre;

	protected $db;

	/**
	 * @param string tablepre table prefix
	 * @param Database handler db
	 * @access public
	 */
	public function DiscuzDao($tablepre, $db) {
		$this->tablepre = $tablepre;
		$this->db = $db;
	}
}
?>
