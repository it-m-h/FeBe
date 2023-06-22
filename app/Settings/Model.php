<?php

declare(strict_types=1);

namespace App\Settings;

use lib\Database;


/**
 * Model :: FeBe - Framework
 */
class Model {
    public $myDB = null;
    public function __construct($method = "run", $param = null) {
        $this->myDB = new Database();
        $this->$method($param);
    }
    // saveSettings
    public function updateSettings($bind) {
        $sql = "UPDATE settings SET settings_value = :settings_value WHERE settings_id = :settings_id";
        //echo $sql;
        return $this->myDB->update($sql, $bind);
    }
    public function getSettings() {
        $sql = "SELECT * FROM settings";
        return $this->myDB->getArray($sql);
    }
    public function getSetting($param = null) {
        $sql = "SELECT * FROM settings WHERE settings_id = " . $param;
        return $this->myDB->getArray($sql);
    }
    public function run() {
    }
    public function __destruct() {
        $this->myDB = null;
    }
}