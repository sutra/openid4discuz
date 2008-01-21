<?php
/*
 * Created on 2008-1-21
 */
/**
 * OpenID Username Cache Data Access Object.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 * @access public
 */
interface OpenIDUsernameCacheDao {
	/**
	 * Insert last number.
	 * 
	 * @access public
	 */
	function insertLastNumber($username, $number);

	/**
	 * Update last number.
	 * 
	 * @access public
	 */
	function updateLastNumber($username, $number);

	/**
	 * Get last number.
	 * 
	 * @access public
	 */
	function getLastNumber($username);
}
?>
