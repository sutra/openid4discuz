<?php
/*
 * Created on 2008-1-21
 */
/**
 * OpenID Identifier Parser.
 * 
 * @author sutra
 * @license http://openid4discuz.redv.com/LICENSE.txt New BSD License
 * @access public
 */
class OpenIDIdentifierParser {
	/**
	 * @access public
	 */
	public static function parseNicknameFromUrl($openid_identifier) {
		$m = preg_match("/^(http[s]?:\/\/)?([^\/]+)/i", $openid_identifier, $matches);
		if (!$m) {
			return $openid_identifier;
		}
	
		$host = $matches[2];
		// xxx.openid.org.cn, xxx.myopenid.com, xxx.openid.cn, xxx.openid.35.com, xxx.openid.org, xxx.mysecond.name, xxx.pip.verisignlabs.com
		if (preg_match("/([^\.\/]+)\.((openid\.org\.cn)|(myopenid\.com)|(openid\.cn)|(openid\.35\.com)|(openid\.org)|(mysecond\.name)|(pip\.verisignlabs\.com))/", $host, $matches)) {
			$ret = $matches[1];
		} else {
			// www.ican.com.cn/xxx
			if(preg_match("/^(http[s]?:\/\/)?[^\/]+[\/]+([^\/]+)/i", $openid_identifier, $matches)) {
				$ret = $matches[2];
			} else {
				$ret = $host;
			}
		}
		return $ret;
	}
}
?>
