<?php

declare(strict_types=1);

namespace App\Settings;
use Valitron\Validator;

class Settings {

    public $response = array();
    private $Model;
    public function __construct($method = 'run', $param = NULL) {
        $this->response['info'][] = 'Settings::construct';
        $this->response['method'] = $method;
        $this->response['param'] = $param;
        $this->Model = new Model(); 
        if ($method)
            $this->$method($param);
    }
    // save Settings
    public function updateSettings($param = NULL){
        if(isset($_POST['settings_value']) && isset($_POST['settings_id'])){
            $bind = array();
            $bind[':settings_id'] = $_POST['settings_id'];
            $bind[':settings_value'] = $_POST['settings_value'];
            //print_r($bind);
            $this->Model->updateSettings($bind);
            echo 1;
        }else{
            echo 0;
        }   
    }
    public function getSettings($param = NULL) {
        return $this->Model->getSettings();
    }
    public function getSettingsGroup($param = NULL) {
        $arr =  $this->Model->getSettings();
        $return = array();
        foreach ($arr as $key => $value) {
            $return[$value['settings_group']][] = $value;
        }
        return $return;
    }

    public function run() {
        //echo json_encode($this->response);
    }
    public function __destruct() {
    }
}