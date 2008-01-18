<?php


/*
 * Created on 2008-1-13
 *
 * Test openid.func.php
 */
/**
 * @author sutra
 * @copyright Copyright &copy; 2001-2008, Redv Soft
 * @license http://openid4discuz.redv.com/LICENSE.txt BSD
 */
require_once 'PHPUnit/Framework.php';

require_once '../include/common.inc.php';

require_once '../plugins/openid/openid.func.php';
require_once '../plugins/openid/common.php';

define('SYS_DEBUG', TRUE);

// print "Username: ".generateUsername("a");
// print "<br />Username: ".generateUsername("sutra");

class OpenIDFuncTest extends PHPUnit_Framework_TestCase {
	public function testGetSID() {
		$sid = GetSID();
		$this->assertTrue(strlen($sid) == 24);

		$sid = GetSID(-1);
		$this->assertTrue(strlen($sid) == 0);

		$sid = GetSID(0);
		$this->assertTrue(strlen($sid) == 0);

		$sid = GetSID(1);
		$this->assertTrue(strlen($sid) == 1);

		$sid = GetSID(97);
		$this->assertTrue(strlen($sid) == 97);
	}
	
	public function testParseNicknameFromUrl() {
		$hosts = array("openid.org.cn", "myopenid.com", "openid.cn", "openid.35.com", "openid.org", "mysecond.name", "pip.verisignlabs.com");
		foreach ($hosts as $key=>$value) {
			echo "\nTest: ".$key."=>".$value;
			$this->assertEquals("test", parseNicknameFromUrl("http://test.".$value));
			$this->assertEquals("test", parseNicknameFromUrl("http://test.".$value."/"));
			$this->assertEquals("test", parseNicknameFromUrl("http://test.".$value."/abc1"));
			$this->assertEquals("test", parseNicknameFromUrl("http://test.".$value."/abc1/"));
			$this->assertEquals("test", parseNicknameFromUrl("http://test.".$value."/abc1/def"));

			$this->assertEquals("test", parseNicknameFromUrl("https://test.".$value));
			$this->assertEquals("test", parseNicknameFromUrl("https://test.".$value."/"));
			$this->assertEquals("test", parseNicknameFromUrl("https://test.".$value."/abc1"));
			$this->assertEquals("test", parseNicknameFromUrl("https://test.".$value."/abc1/"));
			$this->assertEquals("test", parseNicknameFromUrl("https://test.".$value."/abc1/def"));

			$this->assertEquals("test", parseNicknameFromUrl("test.".$value));
			$this->assertEquals("test", parseNicknameFromUrl("test.".$value."/"));
			$this->assertEquals("test", parseNicknameFromUrl("test.".$value."/abc1"));
			$this->assertEquals("test", parseNicknameFromUrl("test.".$value."/abc1/"));
			$this->assertEquals("test", parseNicknameFromUrl("test.".$value."/abc1/def"));
		}
		$hosts = array("www.ican.com.cn");
		foreach ($hosts as $key=>$value) {
			echo "\nTest: ".$key."=>".$value;
			$this->assertEquals("test", parseNicknameFromUrl("http://".$value."/test"));
			$this->assertEquals("test", parseNicknameFromUrl("http://".$value."/test/"));
			$this->assertEquals("test", parseNicknameFromUrl("http://".$value."/test/abc1"));
			$this->assertEquals("test", parseNicknameFromUrl("http://".$value."/test/abc1/"));
			$this->assertEquals("test", parseNicknameFromUrl("http://".$value."/test/abc1/def"));

			$this->assertEquals("test", parseNicknameFromUrl("https://".$value."/test"));
			$this->assertEquals("test", parseNicknameFromUrl("https://".$value."/test/"));
			$this->assertEquals("test", parseNicknameFromUrl("https://".$value."/test/abc1"));
			$this->assertEquals("test", parseNicknameFromUrl("https://".$value."/test/abc1/"));
			$this->assertEquals("test", parseNicknameFromUrl("https://".$value."/test/abc1/def/"));

			$this->assertEquals("test", parseNicknameFromUrl($value."/test"));
			$this->assertEquals("test", parseNicknameFromUrl($value."/test/"));
			$this->assertEquals("test", parseNicknameFromUrl($value."/test/abc1"));
			$this->assertEquals("test", parseNicknameFromUrl($value."/test/abc1/"));
			$this->assertEquals("test", parseNicknameFromUrl($value."/test/abc1/def/"));
		}
	}

	public function testObtainNickname() {
		$this->assertEquals('test', obtainNickname("http://example.org/", array('nickname'=>'test')));
		$this->assertEquals('test', obtainNickname("http://example.org/", array('email'=>'test@example.org')));
		$this->assertEquals('test', obtainNickname("http://test.openid.org.cn/"));
	}
/*
	public function testGenerateUsername() {
		echo '..........................';
		global $abc;
		echo $abc;
		global $tablepre;
		print "---------->".$tablepre;
		echo $tablepre;
		$username = generateUsername("a");
		print "=======>".$username;
	}*/
}
?>
