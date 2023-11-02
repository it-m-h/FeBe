<?php

declare(strict_types=1);

namespace App\User;

use lib\Auth;
use Valitron\Validator;

/**
 * User :: FeBe - Framework
 * @param  string $method
 * @param  string $param
 * @return void
 */
class User {
    /**
     * @var mixed[] $response
     */
    public $response;

    private Model $Model;
    public function __construct(?string $method = 'run', ?string $param = NULL) {
        Auth::initRights(1);
        $this->response['info'][] = 'User::construct';
        $this->response['method'] = $method;
        $this->response['param'] = $param;
        $this->Model = new Model();
        if ($method)
            $this->$method($param);
    }
    /**
     * toggleUserStatus
     *
     * @param  ?string $param
     * @return void
     */
    public function toggleUserStatus(?string $param = NULL) {
        $this->response['info'][] = 'User::toggleUserStatus';
        $this->response['param'] = $param;
        if (!is_null($param)) {
            $id = intval($param);
            if ($id > 0) {
                $operationSuccessful = $this->Model->toggleUserStatus($id);
                if ($operationSuccessful) {
                    $this->response['success'] = 'User -> toggleUserStatus - done';
                } else {
                    $this->response['error'] = 'Fehler beim Ändern des User Status';
                }
            } else {
                $this->response['error'] = 'Ungültige User-ID';
            }
        } else {
            $this->response['error'] = 'User Status nicht geändert, da keine ID angegeben wurde';
        }

        $this->run();
    }
    /**
     * Save
     *
     * @param  ?string $param
     * @return void
     */
    public function Save(?string $param = NULL): void {
        $data = array(
            'user_id' => 0,
            'user_pfad' => '',
            'user_name' => '',
            'user_passwort' => '',
            'user_gruppe' => 0,
            'user_RFID' => ''
        );
        if (!empty($_POST)) {
            $post = $_POST;
            // Daten überprüfen mit Valitron/Validator
            $v = new Validator($post);
            $v->rule('required', 'user_id')->message('darf nicht leer sein');
            $v->rule('integer', 'user_id')->message('muss eine Zahl sein');
            $v->rule('min', 'user_id', 0)->message('muss grösser oder gleich als 0 sein');
            $v->rule('lengthMin', 'user_pfad', 4)->message('muss mindestens 4 Zeichen lang sein');
            $v->rule('regex', 'user_pfad', '/^[a-zA-Z0-9]+$/')->message('nur Buchstaben und Zahlen sind erlaubt');
            $v->rule('lengthMin', 'user_name', 4)->message('muss mindestens 4 Zeichen lang sein');
            $v->rule('lengthMax', 'user_name', 255)->message('darf maximal 255 Zeichen lang sein');
            $v->rule('regex', 'user_name', '/^[a-zA-Z0-9]+$/')->message('nur Buchstaben und Zahlen sind erlaubt');
            $v->rule('lengthMin', 'user_passwort', 4)->message('muss mindestens 4 Zeichen lang sein');
            $v->rule('regex', 'user_passwort', '/^[a-zA-Z0-9._-ç%&()=öäüéàèÖÄÜÉÀÈ£$\/]+$/')->message('Buchstaben und Zahlen sind erlaubt und einige Sonderzeichen');
            $v->rule('required', 'user_gruppe')->message('darf nicht leer sein');
            $v->rule('integer', 'user_gruppe')->message('muss eine Zahl sein');
            $v->rule('min', 'user_gruppe', 1)->message('muss grösser als 1 sein');
            $v->rule('lengthMin', 'user_RFID', 4)->message('muss mindestens 4 Zeichen lang sein');
            $v->rule('regex', 'user_RFID', '/^[a-zA-Z0-9]+$/')->message('nur Buchstaben und Zahlen sind erlaubt');
            // wenn Fehler, dann JSON ausgeben und abbrechen
            if (!$v->validate()) {
                $this->response['error'] = 'Validation nicht erfolgreich';
                $this->response['data'] = $v->errors();
                $this->run();
                return;
            } else {
                $post['user_id'] = intval($post['user_id']);
                $post['user_gruppe'] = intval($post['user_gruppe']);
                $save = true;
                if ($this->Model->userExists($post['user_name'], $post['user_id'])) {
                    $this->response['error'] = 'User mit gleichem Namen bereits vorhanden';
                    $save = false;
                } 
                if ($save && $this->Model->pfadExists($post['user_pfad'], $post['user_id'])) {
                    $this->response['error'] = 'Pfad mit gleichem Namen bereits vorhanden';
                    $save = false;
                } 
                if ($save && $this->Model->rfidExists($post['user_RFID'], $post['user_id'])) {
                    $this->response['error'] = 'RFID mit gleichem Namen bereits vorhanden';
                    $save = false;
                }
                if( $save){
                    if ($post['user_id'] > 0)
                        $data['user_id'] = intval($post['user_id']);
                    if ($post['user_pfad'] != '')
                        $data['user_pfad'] = $post['user_pfad'];
                    if ($post['user_name'] != '')
                        $data['user_name'] = $post['user_name'];
                    if ($post['user_gruppe'] > 0)
                        $data['user_gruppe'] = intval($post['user_gruppe']);
                    if ($post['user_RFID'] != '')
                        $data['user_RFID'] = $post['user_RFID'];
                    // Passwort changed?
                    $checkPW = trim($post['user_passwort']);
                    $pw = $this->Model->getPasswort($data['user_id']);
                    if (isset($pw[0]['user_passwort'])) {
                        $pwInDB = trim($pw[0]['user_passwort']);
                    } else {
                        $pwInDB = '';
                    }
                    if (strstr($pwInDB, $checkPW)) {
                        $data['user_passwort'] = $pwInDB;
                    } else {
                        $data['user_passwort'] = hash('sha512', $checkPW);
                    }
                    $this->response['formdata'] = $data;
                    if ($post['user_id'] == 0) {
                        if ($this->Model->insertUser($data)) {
                            $this->response['success'] = 'User erfolgreich hinzugefügt';
                        } else {
                            $this->response['error'] = 'User nicht hinzugefügt';
                        }
                    } else {
                        if ($this->Model->updateUser($data)) {
                            $this->response['success'] = 'User erfolgreich geändert';
                        } else {
                            $this->response['error'] = 'User nicht geändert';
                        }
                    }
                }
                $this->run();
            }
        }
    }
    /**
     * getUsers
     *
     * @param  ?string $param
     * @return array
     */
    public function getUsers(?string $param = NULL) {
        try {
            return $this->Model->getUsers();
        } catch (\PDOException $e) {
            return array();
        }
    }
    /**
     * getUser
     *
     * @param ?string $param
     * @return void
     */
    public function getUser(?string $param = NULL) {
        if (isset($param)) {
            try {
                $user_id = intval($param);
                $data = $this->Model->getUser($user_id);
                if (is_array($data) && isset($data[0])) {
                    $this->response = $data[0];
                } else {
                    $this->response['error'] = 'User nicht gefunden';
                }
            } catch (\Exception $e) {
                $this->response['error'] = 'User nicht gefunden';
            }
        }
        $this->run();
    }
    /**
     * run
     *
     * @param   ?string $param
     * @return void
     */
    public function run(?string $param = NULL) {
        echo json_encode($this->response);
    }
    /**
     * __destruct
     *
     * @return void
     */
    public function __destruct() {
    }
}