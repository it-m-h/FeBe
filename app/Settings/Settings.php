<?php

declare(strict_types=1);

namespace App\Settings;
use lib\Auth;
use Valitron\Validator;

/**
 * Settings :: FeBe - Framework
 * @param  string $method
 * @param  string $param
 * @return void
 */
class Settings {
    /**
     * @var mixed[] $response
     */
    public $response;
    private Model $Model;
    public function __construct(?string $method = 'run', ?string $param = NULL) {
        Auth::initRights(1);
        $this->response['info'][] = 'Settings::construct';
        $this->response['method'] = $method;
        $this->response['param'] = $param;
        $this->Model = new Model(); 
        if ($method)
            $this->$method($param);
    }  
    /**
     * updateSettings
     *
     * @param  ?string $param
     * @return void
     */
    public function updateSettings(?string $param = NULL){
        if(isset($_POST['settings_value']) && isset($_POST['settings_id'])){
            $bind = array();
            $bind['settings_value'] = $_POST['settings_value'];
            $bind['settings_id'] = intval($_POST['settings_id']);
            //print_r($bind);
            $this->Model->updateSettings($bind);
            echo 1;
        }else{
            echo 0;
        }   
    }    
    /**
     * getSettings
     *
     * @param  ?string $param
     * @return array<array<string, mixed>>
     */
    public function getSettings(?string $param = NULL) {
        try {
            return $this->Model->getSettings();
        } catch (\PDOException $e) {
            return array();
        }
    }    
    /**
     * getSettingsGroup
     *
     * @param  ?string $param
     * @return  array<int|string, array<int, array<string, mixed>>>
     */
    public function getSettingsGroup(?string $param = NULL): array {
        $arr =  $this->Model->getSettings();
        $return = array();

        foreach ($arr as $key => $value) {
            if(isset($value['settings_group'])){
                if(!isset($return[$value['settings_group']])){
                    $return[$value['settings_group']] = array();
                }
                $return[$value['settings_group']][] = $value;
            }
            
        }
        return $return;
    }
    
    /**
     * run
     *
     * @return void
     */
    public function run() {
        //echo json_encode($this->response);
    }    
    /**
     * __destruct
     *
     * @return void
     */
    public function __destruct() {
    }
}