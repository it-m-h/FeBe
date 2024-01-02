<?php
// php vendor/bin/phpunit tests/TestLogin.php --colors --testdox
declare(strict_types=1);
define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));
require BASEPATH.'vendor/autoload.php';
use lib\Request;

/**
 * TestLogin
 * Testet die Login-Funktionen
 * @covers \lib\Request
 */
class TestLogin extends PHPUnit\Framework\TestCase {
        
    /**
     * testRouteInfo
     * Testet die Route testRoute und gibt 200 zurück, wenn die Seite erfolgreich geladen wurde
     *
     * @return void
     */
    public function testRouteInfo() {
        $req = Request::OpenURL('testRoute');
        $this->assertStringContainsString('testRoute', $req['body']);
        $this->assertEquals(200, $req['status_code']); 
    }
    
    /**
     * testRouteAccountLogin
     * Testet die Route Account/Login und gibt 200 zurück, wenn die Seite erfolgreich geladen wurde
     *
     * @return void
     */
    public function testRouteAccountLogin() {
        $req = Request::OpenURL('Account/Login');
        $this->assertEquals(200, $req['status_code']);
    }
    
    /**
     * testRouteAccountCheck
     * Testet die Route Account/check und gibt 1 zurück, wenn der Login erfolgreich war (Admin:1234)
     * @return void
     */
    public function testRouteAccountCheck() {
        // Passwort in sha512
        $pass = hash('sha512', '1234');
        $req = Request::OpenURL('Account/check', 'POST', array('name' => 'admin', 'password' => $pass));
        $return = intval($req['body']);
        // Überprüfen, ob $return numerisch ist
        $this->assertIsNumeric($return);
        // Überprüfen, ob $return gleich 1 ist
        $this->assertEquals(1, $return);
        // Überprüfen des Statuscodes
        $this->assertEquals(200, $req['status_code']);
        // Optional: Ausgabe von $req für Debugging-Zwecke
        //var_dump($req);
    }
    
    /**
     * testRouteAccountLogout
     *  Testet die Route Account/Logout und gibt 302 zurück, wenn der Logout erfolgreich war
     *
     * @return void
     */
    public function testRouteAccountLogout() {
        $req = Request::OpenURL('Account/Logout');
        // Überprüfen Sie den Statuscode auf Weiterleitung
        $this->assertEquals(302, $req['status_code']);
    }
}