<?php

declare(strict_types=1);

namespace App\Settings;

use lib\Database;


/**
 * Model :: FeBe - Framework
 */
class Model {
    public Database $myDB;
    
    /**
     * __construct
     *
     * @param  string $method
     * @param  string $param
     * @return void
     */
    public function __construct(?string $method = "run", ?string $param = null) {
        $this->myDB = new Database();
        $this->$method($param);
    }  
    /**
     * updateSettings
     *
     * @param array{
     *  settings_value: string,
     *  settings_id: int
     * } $param
     * @return bool
     */
    public function updateSettings(array $param): bool {
        try {
            $sql = "UPDATE settings SET settings_value = :settings_value WHERE settings_id = :settings_id";
            $this->myDB->update($sql, $param);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }    
    /**
     * getSettings
     *
     * @return array<array<string, mixed>>
     */
    public function getSettings(): array {  
        try {
            $sql = "SELECT * FROM settings";
            return $this->myDB->getArray($sql);
        } catch (\PDOException $e) {
            return array();
        }
    }    
    /**
     * getSetting
     *
     * @param  int $id
     * @return array<array<string, mixed>>
     */
    public function getSetting(int $id): array {
            try {
            $sql = "SELECT * FROM settings WHERE settings_id = :settings_id";
            $bind = array(
                ':settings_id' => $id
            );
            return $this->myDB->getArray($sql, $bind);
        } catch (\Exception $e) {
            return array();
        }
    }    
    /**
     * run
     *
     * @return void
     */
    public function run() {
    }    
    /**
     * __destruct
     *
     * @return void
     */
    public function __destruct() {
        //$this->myDB = null;
    }
}