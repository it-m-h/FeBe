<?php

declare(strict_types=1);

namespace App\User;
use Valitron\Validator;

class User 
{
    private $config = array();
    private $Model;
    public $response = array();
    public function __construct($method = 'run', $param = NULL) {
        $this->response['info'][] = 'User::construct';
        $this->response['method'] = $method;
        $this->response['param'] = $param;
        $this->Model = new Model();
        if($method) $this->$method($param);
    }
    // toggleUserStatus
    public function toggleUserStatus($param = NULL) {
        $this->Model->toggleUserStatus($param);
        $this->response['success'] = 'User -> toggleUserStatus - done';
        $this->run();
    }
    // Save
    public function Save($param = NULL) {
        if(isset($_POST)){
            $post = $_POST;
            // Daten überprüfen mit Valitron/Validator
            $v = new Validator($post);
            $v->rule('required', 'user_id')->message('darf nicht leer sein');
            $v->rule('integer', 'user_id')->message('muss eine Zahl sein');
            $v->rule('min', 'user_id', 0)->message('muss grösser oder gleich als 0 sein');
            $v->rule('lengthMin', 'user_pfad', 4)->message('muss mindestens 4 Zeichen lang sein');
            $v->rule('regex', 'user_pfad', '/^[a-zA-Z0-9]+$/')->message('nur Buchstaben und Zahlen sind erlaubt');
            $v->rule('lengthMin', 'user_name', 4)->message('muss mindestens 4 Zeichen lang sein');
            $v->rule('regex', 'user_name', '/^[a-zA-Z0-9]+$/')->message('nur Buchstaben und Zahlen sind erlaubt');
            $v->rule('lengthMin', 'user_passwort', 4)->message('muss mindestens 4 Zeichen lang sein');
            $v->rule('regex', 'user_passwort', '/^[a-zA-Z0-9_-ç%&()=öäüéàèÖÄÜÉÀÈ£$\/]+$/')->message('Buchstaben und Zahlen sind erlaubt und einige Sonderzeichen');
            $v->rule('integer', 'user_gruppe')->message('muss eine Zahl sein');
            $v->rule('min', 'user_gruppe', 1)->message('muss grösser als 1 sein');
            $v->rule('lengthMin', 'user_RFID', 4)->message('muss mindestens 4 Zeichen lang sein');
            $v->rule('regex', 'user_RFID', '/^[a-zA-Z0-9]+$/')->message('nur Buchstaben und Zahlen sind erlaubt');
            // wenn Fehler, dann JSON ausgeben und abbrechen
            if(!$v->validate()) {
                $this->response['error'] = 'Validation nicht erfolgreich';
                $this->response['data'] = $v->errors();
                $this->run();
                return;
            }else{
                $this->response['formdata'] = $post;
                if($post['user_id']==0){
                    $this->Model->insertUser($post);
                }else{
                    $this->Model->updateUser($post);
                }
                $this->response['success'] = 'Validation erfolgreich';
                $this->run();
            }
        }
    }
    public function getUsers($param = NULL) {
        return $this->Model->getUsers();
    }
    public function getUser($param = NULL) {
        $data =  $this->Model->getUser($param);
        if(is_array($data) && isset($data[0])){
            $this->response = $data[0];
        }else{
            $this->response['error'] = 'User nicht gefunden';
        }
        $this->run();
    }
    public function run($param = NULL)
    {
        echo json_encode($this->response);
    }
    public function __destruct() {
    }
}