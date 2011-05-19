<?php
 
class testTesting extends PHPUnit_Framework_TestCase
{
    public function testFailTest()
    {
        $this->assertEquals(0, 1);
    }
 
    public function testSuccessfulTest()
    {
        $this->assertEquals(1, 1);
    }
}
?>
