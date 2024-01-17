<?php
// php vendor/bin/phpunit tests/TestRequest.php --colors --testdox
declare(strict_types=1);
define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));
require BASEPATH.'vendor/autoload.php';
define('DB_FILE', BASEPATH.'data'.DS.'FeBe.sqlite3');

class TestDatabase extends PHPUnit\Framework\TestCase {

    // Variable für die Datenbankverbindung
    private $server = '172.30.219.144';
    private $database = 'FeBe';

    private $DatenbankSQLITE = true;
    private $DatenbankMYSQL = false;

    /* public function testDatabaseConnection() {
        $body = new \PDO('mysql:host='.$this->server.';dbname='.$this->database, 'root', '');
        $this->assertNotNull($body);
        $this->assertIsObject($body);
    } */
    public function testDatabaseConnectionWithKurs() {
        if($this->DatenbankSQLITE){
            $body = new \PDO('sqlite:'.$_SESSION['DB']);
            $this->assertNotNull($body);
            $this->assertIsObject($body);
        }elseif($this->DatenbankMYSQL){
            $body = new \PDO('mysql:host='.$this->server.';dbname='.$this->database, 'kurs', 'kurs');
            $this->assertNotNull($body);
            $this->assertIsObject($body);
        }
        $sql = "SELECT * FROM users";
        $statement = $body->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->assertNotNull($result);
        $this->assertIsArray($result);
    }
    /*
    Example: Prozedur - Testing
    public function testProzedurCall(){
        $body = new \PDO('mysql:host='.$this->server.';dbname='.$this->database, 'kurs', 'kurs');
        $sql = "Call FreeCar(:von, :bis)";
        $statement = $body->prepare($sql);
        $von = '2021-01-01';
        $bis = '2021-01-02';
        $statement->bindParam(':von', $von, PDO::PARAM_STR);
        $statement->bindParam(':bis', $bis, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->assertNotNull($result);
        $this->assertIsArray($result);
    }
    */

}
