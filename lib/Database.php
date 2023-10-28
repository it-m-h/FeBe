<?php

declare(strict_types=1);

namespace lib;

/**
 * Database :: FeBe - Framework
 */
class Database {

    private \PDO|null $db;

    /**
     * __construct
     *
     * @param  string $method
     * @param  string $param
     * @return void
     */
    public function __construct(string $method = '', string $param = '') {
        $this->checkDBSqlite3(BASEPATH.'data/FeBe.sqlite3');
        $this->db = new \PDO('sqlite:'.BASEPATH.'data/FeBe.sqlite3');
        //$this->db = new \PDO('mysql:host=localhost;dbname=FeBe', 'root', '');
        if ($method != '') {
            $this->$method($param);
        }
    }
    // check if database exists    
    /**
     * checkDBSqlite3
     *
     * @param  string $file
     * @return void
     */
    public function checkDBSqlite3(string $file) {
        if (!file_exists($file)) {
            $sql = file_get_contents(BASEPATH.'data/SQLITE3.sql');
            if ($sql === false) {
                throw new \RuntimeException("Die SQL-Datei konnte nicht gelesen werden.");
            }
            $db = new \PDO('sqlite:'.$file);
            $db->exec($sql);
            $db = null;
        }
    }
    /**
     * setSettingsDefine
     *
     * @return void
     */
    public function setSettingsDefine() {
        $sql = "SELECT * FROM settings";
        $result = $this->getArray($sql);
        if (is_array($result) && !empty($result)) {
            foreach ($result as $key => $value) {
                if (is_array($value) && isset($value['settings_name']) && is_string($value['settings_name']) && !defined($value['settings_name'])) {
                    define($value['settings_name'], $value['settings_value']);
                }
            }
        }
    }
    /**
     * getSettings
     *
     * @param  string $param
     * @return array
     */
    public function getSettings(string $param = ''): array {
        $result = array();
        $return = array();
        if ($param != '') {
            $sql = "SELECT * FROM settings WHERE settings_name = :name";
            $bind = array(':name' => $param);
            $result = $this->getArray($sql, $bind);
        } else {
            $sql = "SELECT * FROM settings";
            $result = $this->getArray($sql);
        }
        foreach ($result as $key => $value) {
            if (is_array($value) && isset($value['settings_name'])) {
                $return[$value['settings_name']] = $value['settings_value'];
            }
        }
        return $return;
    }
    /**
     * getArray
     *
     * @param  string $sql
     * @param  array $bind
     * @return array
     */
    public function getArray(string $sql, ?array $bind = null): array {
        if ($this->db instanceof \PDO) {
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
                return array();
            }
        } else {
            return array();
        }
    }
    /**
     * insert_bind
     *
     * @param  array $data
     * @param  string $table
     * @return bool Methode liefert true oder false zurück
     */
    public function insert_bind(array $data, string $table): bool {

        if (!is_array($data) || $table == '') {
            return false;
        } else {
            if ($this->db instanceof \PDO) {
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
            } else {
                return false;
            }
        }
    }
    /**
     * update_bind
     *
     * @param  array $data 
     * @param  string $table
     * @return bool Methode liefert true oder false zurück
     */
    public function update_bind(array $data, string $table): bool {
        if (!is_array($data) || $table == '') {
            return false;
        } else {
            if ($this->db instanceof \PDO) {
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
            } else {
                return false;

            }
        }
    }
    /**
     * insert
     *
     * @param  string $sql
     * @param  array $bind
     * @return int Methode liefert die letzte ID zurück
     */
    public function insert(string $sql, ?array $bind = null): int {

        if ($this->db instanceof \PDO) {
            try {
                $stmt = $this->db->prepare($sql);
                if ($bind != null) {
                    foreach ($bind as $key => $value) {
                        $stmt->bindValue($key, $value);
                    }
                }
                $stmt->execute();
                return intval($this->db->lastInsertId());
            } catch (\Exception $e) {
                return 0;
            }
        } else {
            return 0;
        }

    }
    /**
     * update
     *
     * @param  string $sql
     * @param  array $bind
     * @return int Methode liefert die Anzahl der betroffenen Zeilen zurück
     */
    public function update(string $sql, ?array $bind = null): int {

        if ($this->db instanceof \PDO) {
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
                return 0;
            }
        } else {
            return 0;
        }

    }
    /**
     * delete
     *
     * @param  string $sql
     * @param  array $bind
     * @return int Methode liefert die Anzahl der betroffenen Zeilen zurück
     */
    public function delete(string $sql, ?array $bind = null): int {

        if ($this->db instanceof \PDO) {
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
                return 0;
            }
        } else {
            return 0;
        }

    }
    /**
     * run
     *
     * @param  string $sql
     * @param  array $bind
     * @return int Methode liefert die Anzahl der betroffenen Zeilen zurück
     */
    public function run(string $sql, ?array $bind = null): int {
        if ($this->db instanceof \PDO) {
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
                return 0;
            }
        } else {
            return 0;
        }
    }
    /**
     * __destruct
     *
     * @return void
     */
    public function __destruct() {
        // DB schliessen
        $this->db = null;
    }
}