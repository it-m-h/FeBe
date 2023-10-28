<?php
// php vendor/bin/phpunit tests/TestRequest.php --colors --testdox
declare(strict_types=1);
define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));
require BASEPATH.'vendor/autoload.php';

class TestRequest extends PHPUnit\Framework\TestCase {

    public function testClient() {
        $client = \lib\Request::client();
        $this->assertNotNull($client);
        $this->assertIsArray($client);
    }

    public function testHeader() {
        $header = \lib\Request::header();
        $this->assertNotNull($header);
        $this->assertIsArray($header);
    }
}