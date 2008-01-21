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
	 * Bind openid to a discuz account.
	 * 
	 * @access public
	 */
	function bindOpenID($uid, $openid_identifier);

	/**
	 * Unbind openid from discuz account.
	 * 
	 * @access public
	 */
	function unbindOpenID($uid, $openid_identifier);
}
?>