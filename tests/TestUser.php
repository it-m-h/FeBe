<?php
// php vendor/bin/phpunit tests/TestUser.php --colors --testdox
declare(strict_types=1);
define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));
require BASEPATH.'vendor/autoload.php';

// File in Tests/UserTest.php
class TestUser extends PHPUnit\Framework\TestCase {

    // db check
    public function testTable() {
        $db = new \lib\Database();
        $this->assertNotNull($db);
        // is array getData
        $this->assertIsArray($db->getArray('SELECT * FROM user'));
    }

    public function testGetUsers() {
        $user = new \App\User\User();
        // Call the getUsers method
        $result = $user->getUsers();
        // Assert that the result is an array
        $this->assertIsArray($result);
    }

    // toggle UserStatus check
    public function testToggleUserStatus() {
        $user = new \App\User\Model();
        // Call the toggleUserStatus method
        $result = $user->toggleUserStatus(999);
        // Assert that the result ist true
        // $this->assertTrue($result);
        // Assert that the result is false
        $this->assertFalse($result);
    }

    public function testThatStringMatch() {
        $sring = 'home';
        $this->assertSame($sring, 'home');
    }

    public function testThatNumberAddUp() {
        $this->assertEquals(10, 5 + 5);
    }
}