<?php
/*
 * Created on 2008-1-21
 */
/**
 * OpenID Data Access Object.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 * @access public
 */
interface OpenIDDao {
	/**
	 * Get user id by openid identifer.
	 * 
	 * @access public
	 */
	public function getUserIDByOpenID($openid_identifier);

	/**
	 * Is username exists.
	 * @access public
	 */
	public function isUsernameExists($username);

	/**
	 * Find next number of the username.
	 * 
	 * @access public
	 */
	public function findNextNumber($username, $number);

	/**
	 * Bind openid to a discuz account.
	 * 
	 * @access public
	 */
	public function bindOpenID($uid, $openid_identifier);

	/**
	 * Unbind openid from discuz account.
	 * 
	 * @access public
	 */
	public function unbindOpenID($uid, $openid_identifier);
}
?>