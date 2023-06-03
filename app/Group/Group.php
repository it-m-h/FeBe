<?php

declare(strict_types=1);

namespace App\Group;
use Valitron\Validator;

class Group {
    public $response = array();
    private $Model;
    public function __construct($method = 'run', $param = NULL) {
        $this->response['info'][] = 'Group::construct';
        $this->response['method'] = $method;
        $this->response['param'] = $param;
        $this->Model = new Model();
        if ($method)
            $this->$method($param);
    }
    public function getGroups($param = NULL) {
        return $this->Model->getGroups();
    }
    public function getGroup($param = NULL) {
        $data = $this->Model->getGroup($param);
        if (is_array($data) && isset($data[0])) {
            $this->response = $data[0];
        } else {
            $this->response['error'] = 'Group nicht gefunden';
        }
        $this->run();
    }
    public function toggleGroupStatus($param = NULL) {
        $this->response['info'][] = 'Group::toggleGroupStatus';
        $this->response['param'] = $param;
        if (isset($param)) {
            $this->Model->toggleGroupStatus($param);
            $this->response['success'] = 'Group Status geändert';
        } else {
            $this->response['error'] = 'Group Status nicht geändert';
        }
        $this->run();
    }
    public function Save($param = NULL) {
        if (isset($_POST)) {
            $post = $_POST;
            // Daten überprüfen mit Valitron/Validator
            $v = new Validator($post);
            $v->rule('required', 'group_id')->message('darf nicht leer sein');
            $v->rule('integer', 'group_id')->message('muss eine Zahl sein');
            $v->rule('min', 'group_id', 0)->message('muss grösser oder gleich als 0 sein');
            $v->rule('lengthMin', 'group_name', 4)->message('muss mindestens 4 Zeichen lang sein');
            $v->rule('regex', 'group_name', '/^[a-zA-Z0-9öäüéàèÖÄÜÉÀÈ]+$/')->message('nur Buchstaben und Zahlen sind erlaubt');
            $v->rule('integer', 'group_rights')->message('muss eine Zahl sein');
            $v->rule('min', 'group_rights', 1)->message('muss grösser als 1 sein');
            // wenn Fehler, dann JSON ausgeben und abbrechen
            if (!$v->validate()) {
                $this->response['error'] = 'Validation nicht erfolgreich';
                $this->response['data'] = $v->errors();
                $this->run();
                return;
            } else {
                $this->response['formdata'] = $post;
                if ($post['group_id'] == 0) {
                    $this->Model->insert($post);
                } else {
                    $this->Model->update($post);
                }
                $this->response['success'] = 'Validation erfolgreich';
                $this->run();
            }
        }
    }
    public function run() {
        echo json_encode($this->response);
    }
    public function __destruct() {
    }
}