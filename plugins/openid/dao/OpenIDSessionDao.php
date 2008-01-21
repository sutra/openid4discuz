<?php
/*
 * Created on 2008-1-21
 *
 */
/**
 * OpenID Session Data Access Object.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 * @access public
 */
interface OpenIDSessionDao {
	/**
	 * Get openid from the session.
	 * 
	 * @access public
	 */
	function getOpenIDFromSession($sid);

	/**
	 * Delete openid from the session.
	 * 
	 * @access public
	 */
	function deleteOpenIDSession($sid);

	/**
	 * Update openid of this session.
	 * 
	 * @access public
	 */
	function updateOpenIDSession($sid, $openid_identifier);
}
?>
