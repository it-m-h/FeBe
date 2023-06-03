<?php

declare(strict_types=1);

namespace lib;

class Database {

    public $db;
    public $init;

    public function __construct($method = '', $param = '') {
        $this->db = new \PDO('sqlite:'.BASEPATH.'data/FeBe.sqlite3');
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