<?php

declare(strict_types=1);

namespace lib;

class Database {

    public $db;
    public $file;
    public $init;

    public function __construct($method = '', $param = '') {    
        $this->checkDBSqlite3(BASEPATH.'data/FeBe.sqlite3'); 
        $this->db = new \PDO('sqlite:'.BASEPATH.'data/FeBe.sqlite3');
        if ($method != '') {
            $this->$method($param);
        }
        //$this->db = new \PDO('mysql:host=localhost;dbname=FeBe', 'root', '');
    }
    // check if database exists
    public function checkDBSqlite3($file) {
        if (!file_exists($file)) {
            $sql = file_get_contents(BASEPATH.'data/SQLITE3.sql');
            $db = new \PDO('sqlite:'.$file);
            $db->exec($sql);
            $db = null;
        } 
    }
    public function setSettingsDefine() {
        $sql = "SELECT * FROM settings";
        $result = $this->getArray($sql);
        foreach ($result as $key => $value) {
            define($value['settings_name'], $value['settings_value']);
        }
    }
    public function getSettings($param = '') {
        $result = array();
        $return = array();
        if ($param != '') {
            $sql = "SELECT * FROM settings WHERE settings_name = :name";
            $bind = array(':name' => $param);
            $result = $this->getArray($sql, $bind);
        }else{
            $sql = "SELECT * FROM settings";
            $result = $this->getArray($sql);
        }
        foreach ($result as $key => $value) {
            $return[$value['settings_name']] = $value['settings_value'];
        }
        return $return;
    }
    public function getArray($sql, $bind = null) {
        try {
            $stmt = $this->db->prepare($sql);
            if ($bind != null) {
                foreach ($bind as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
            }
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }
    /**
     * insert_bind
     *
     * @param  array $data
     * @param  string $table
     * @return bool Methode liefert true oder false zurück
     */
    public function insert_bind($data, $table) {

        if (!is_array($data) || $table == '') {
            return false;
        } else {
            try {
                $sql = '';
                $fields = array();
                $bind = array();
                $values = array();
                foreach ($data as $key => $value) {
                    $fields[] = $key;
                    $bind[] = ':'.$key;
                    $values[':'.$key] = $value;
                }
                $sql = 'INSERT INTO '.$table.' ('.implode(',', $fields).') VALUES ('.implode(',', $bind).')';
                $stmt = $this->db->prepare($sql);
                foreach ($values as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
                $success = $stmt->execute();
                return $success ? true : false;
            } catch (\Exception $e) {
                return false;
            }
        }
    }
    /**
     * update_bind
     *
     * @param  int $id  Primary Key als Zahl
     * @return bool Methode liefert true oder false zurück
     */
    public function update_bind($data, $table) {
        if (!is_array($data) || $table == '') {
            return false;
        } else {
            try {
                $sql = '';
                $fields = array();
                $bind = array();
                $values = array();
                foreach ($data as $key => $value) {
                    $fields[] = $key.' = :'.$key;
                    $values[':'.$key] = $value;
                }
                $sql = 'UPDATE '.$table.' SET '.implode(',', $fields).' WHERE id = :id';
                $stmt = $this->db->prepare($sql);
                foreach ($values as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
                $success = $stmt->execute();
                return $success ? true : false;
            } catch (\Exception $e) {
                return false;
            }
        }
    }
    public function insert($sql, $bind = null) {
        try {
            $stmt = $this->db->prepare($sql);
            if ($bind != null) {
                foreach ($bind as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
            }
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (\Exception $e) {
            return false;
        }
    }
    public function update($sql, $bind = null) {
        try {
            $stmt = $this->db->prepare($sql);
            if ($bind != null) {
                foreach ($bind as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
            }
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\Exception $e) {
            return false;
        }
    }
    public function delete($sql, $bind = null) {
        try {
            $stmt = $this->db->prepare($sql);
            if ($bind != null) {
                foreach ($bind as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
            }
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\Exception $e) {
            return false;
        }
    }
    public function run($sql, $bind = null) {
        try {
            $stmt = $this->db->prepare($sql);
            if ($bind != null) {
                foreach ($bind as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
            }
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\Exception $e) {
            return false;
        }
    }
    public function __destruct() {
        // DB schliessen
        $this->db = null;
    }
}