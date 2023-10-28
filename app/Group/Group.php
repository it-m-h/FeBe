<?php

declare(strict_types=1);

namespace App\Group;

use lib\Auth;
use Valitron\Validator;

/**
 * Group :: FeBe - Framework
 * @param  string $method
 * @param  string $param
 * @return void
 */
class Group {
    /**
     * @var mixed[] $response
     */
    public $response;
    private Model $Model;    
    public function __construct(?string $method = 'run', ?string $param = NULL) {
        Auth::initRights(1);
        $this->response['info'][] = 'Group::construct';
        $this->response['method'] = $method;
        $this->response['param'] = $param;
        $this->Model = new Model();
        if ($method)
            $this->$method($param);
    }
    /**
     * toggleGroupStatus
     *
     * @param  ?string $param
     * @return void
     */
    public function toggleGroupStatus(?string $param = NULL) {
        $this->response['info'][] = 'Group::toggleGroupStatus';
        $this->response['param'] = $param;
        if (!is_null($param)) {
            $id = intval($param);
            $this->Model->toggleGroupStatus($id);
            $this->response['success'] = 'Group Status geändert';
        } else {
            $this->response['error'] = 'Group Status nicht geändert';
        }
        $this->run();
    }
         
    /**
     * Save
     *
     * @param  ?string $param
     * @return void
     */
    public function Save(?string $param = NULL) {
        $data = array(
            'group_id' => 0,
            'group_rights' => 0,
            'group_name' => ''
        );
        if (!empty($_POST)) {
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
                if ($post['group_id'])
                    $data['group_id'] = intval($post['group_id']);
                 if ($post['group_rights'])
                    $data['group_rights'] = intval($post['group_rights']);
                if ($post['group_name'])
                    $data['group_name'] = $post['group_name'];

                $this->response['formdata'] = $post;
                if ($post['group_id'] == 0) {
                    $this->Model->insert($data);
                } else {
                    $this->Model->update($data);
                }
                $this->response['success'] = 'Validation erfolgreich';
                $this->run();
            }
        }
    }


    /**
     * getGroups
     *
     * @param  ?string $param
     * @return array<array<string, mixed>>
     */
    public function getGroups(?string $param = NULL) {
        try {
            return $this->Model->getGroups();
        } catch (\PDOException $e) {
            return array();
        }
    }
    /**
     * getGroup
     *
     * @param  ?string $param
     * @return void
     */
    public function getGroup(?string $param = NULL) {
        if (isset($param)) {
            try {
                $group_id = intval($param);
                $data = $this->Model->getGroup($group_id);
                if (is_array($data) && isset($data[0])) {
                    $this->response = $data[0];
                } else {
                    $this->response['error'] = 'Group nicht gefunden';
                }
            } catch (\Exception $e) {
                $this->response['error'] = 'Group nicht gefunden';
            }
        }
        $this->run();
    }
    /**
     * run
     *
     * @return void
     */
    public function run(): void {
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