<?php
/*
 * Created on 2008-1-13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once 'PHPUnit/Framework.php';

class OpenID4DiscuzTest extends PHPUnit_Framework_TestCase {
	public function testNewArrayIsEmpty() {
		// Create the Array fixture.
		$fixture = array ();

		// Assert that the size of the Array fixture is 0.
		$this->assertEquals(0, sizeof($fixture));
	}

	public function testArrayContainsAnElement() {
		// Create the Array fixture.
		$fixture = array ();

		// Add an element to the Array fixture.
		$fixture[] = 'Element';

		// Assert that the size of the Array fixture is 1.
		$this->assertEquals(1, sizeof($fixture));
	}
}
?>
