<?php
// composer autoload
require __DIR__.'./../vendor/autoload.php';

// File in Tests/UserTest.php
class TestUser extends PHPUnit\Framework\TestCase {

    // db check
    public function testdb() {
        $db = new \Lib\Database();
        $this->assertNotNull($db);
        // is array getData
        $this->assertIsArray($db->getArray('SELECT * FROM user'));
    }


    public function testThatStringMatch() {
        $sring = 'home';
        $this->assertSame($sring, 'home');
    }

    


    public function testThatNumberAddUp() {
        $this->assertEquals(10, 5 + 5);
    }
}