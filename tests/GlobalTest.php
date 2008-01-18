<?php
/*
 * Created on 2008-1-16
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once 'PHPUnit/Framework.php';
$globalVar = 'foo';
echo $globalVar;
class GlobalTest extends PHPUnit_Framework_TestCase
{
    public function testGlobal()
    {
        echo '==>'.$GLOBALS['globalVar'];
        $this->assertEquals('foo', $GLOBALS['globalVar']);
    }
}
//GlobalTest::testGlobal();
?>
