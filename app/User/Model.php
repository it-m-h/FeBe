<?php

declare(strict_types=1);

namespace App\User;

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
     * getUsers
     *
     *  @return array
     */
    public function getUsers(): array {
        try {
            $sql = "Select * from users LEFT JOIN groups ON users.user_gruppe = groups.group_id ORDER BY user_active DESC, user_id ASC";
            return $this->myDB->getArray($sql);
        } catch (\PDOException $e) {
            return array();
        }
    }
    /**
     * getUser
     *
     * @param  int $id
     * @return array
     */
    public function getUser(int $id): array {
        // User exists with this ID?
        try {
            $sql = "Select * from users LEFT JOIN groups ON users.user_gruppe = groups.group_id WHERE user_id = :id";
            $bind = array(
                ':id' => $id
            );
            return $this->myDB->getArray($sql, $bind);
        } catch (\Exception $e) {
            return array();
        }
    }

    /** 
     * userExists
     * 
     * @param string $user_name
     * @param int $id
     * @return bool
     */
    public function userExists(string $user_name, int $id): bool {
        try {
            $sql = "Select * from users WHERE user_name = :user_name";
            if($id > 0){
                $sql .= " AND user_id != :user_id";
                $bind = array(
                    ':user_name' => $user_name,
                    ':user_id' => $id
                );
            } else{
                $bind = array(
                    ':user_name' => $user_name
                );
            }
            $result = $this->myDB->getArray($sql, $bind);
            if (count($result) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * pfadExists
     * 
     * @param string $user_pfad
     * @param int $id
     * @return bool
     */
    public function pfadExists(string $user_pfad, int $id): bool {
        try {
            $sql = "Select * from users WHERE user_pfad = :user_pfad";
            if ($id > 0) {
                $sql .= " AND user_id != :user_id";
                $bind = array(
                    ':user_pfad' => $user_pfad,
                    ':user_id' => $id
                );
            } else {
                $bind = array(
                    ':user_pfad' => $user_pfad
                );
            }
            $result = $this->myDB->getArray($sql, $bind);
            if (count($result) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /** 
     * rfidExists
     * 
     * @param string $user_rfid
     * @param int $id
     * @return bool
     */
    public function rfidExists(string $user_rfid, int $id): bool {
        try {
            $sql = "Select * from users WHERE user_RFID = :user_RFID";
            if ($id > 0) {
                $sql .= " AND user_id != :user_id";
                $bind = array(
                    ':user_RFID' => $user_rfid,
                    ':user_id' => $id
                );
            } else {
                $bind = array(
                    ':user_RFID' => $user_rfid
                );
            }
            $result = $this->myDB->getArray($sql, $bind);
            if (count($result) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }


    
    /**
     * insertUser
     *
     * @param array{
     *  user_pfad: string,
     *  user_name: string,
     *  user_passwort: string,
     *  user_gruppe: int,
     *  user_RFID: string
     * } $param
     * @return bool
     */
    public function insertUser(array $param): bool {
        try {
            $sql = "INSERT INTO users (user_pfad, user_name, user_passwort,user_gruppe, user_RFID) VALUES (:user_pfad, :user_name, :user_passwort, :user_gruppe, :user_RFID)";
            $bind = array(
                ':user_pfad' => $param['user_pfad'],
                ':user_name' => $param['user_name'],
                ':user_passwort' => $param['user_passwort'],
                ':user_gruppe' => $param['user_gruppe'],
                ':user_RFID' => $param['user_RFID']
            );
            $this->myDB->insert($sql, $bind);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
    /**
     * updateUser
     *
     * @param array{
     *  user_pfad: string,
     *  user_name: string,
     *  user_passwort: string,
     *  user_gruppe: int,
     *  user_RFID: string,
     *  user_id: int
     * } $param
     * @return bool
     */
    public function updateUser(array $param): bool {
        // User exists with this ID?
        $user = $this->getUser($param['user_id']);
        if (!isset($user[0]['user_id'])) {
            return false;
        }
        try {
            $passwort = $this->getPasswort($param['user_id']);
            if ($passwort[0]['user_passwort'] == $param['user_passwort']) {
                $sql = "UPDATE users SET user_pfad = :user_pfad, user_name = :user_name, user_gruppe = :user_gruppe, user_RFID = :user_RFID WHERE user_id = :user_id";
                $bind = array(
                    ':user_pfad' => $param['user_pfad'],
                    ':user_name' => $param['user_name'],
                    ':user_gruppe' => $param['user_gruppe'],
                    ':user_RFID' => $param['user_RFID'],
                    ':user_id' => $param['user_id']
                );
            } else {
                $sql = "UPDATE users SET user_pfad = :user_pfad, user_name = :user_name, user_passwort = :user_passwort, user_gruppe = :user_gruppe, user_RFID = :user_RFID WHERE user_id = :user_id";
                $bind = array(
                    ':user_pfad' => $param['user_pfad'],
                    ':user_name' => $param['user_name'],
                    ':user_passwort' => $param['user_passwort'],
                    ':user_gruppe' => $param['user_gruppe'],
                    ':user_RFID' => $param['user_RFID'],
                    ':user_id' => $param['user_id']
                );
            }
            $this->myDB->update($sql, $bind);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
    /**
     * toggleUserStatus
     *
     * @param  int $param
     * @return bool
     */
    public function toggleUserStatus(int $param): bool {
        // User exists with this ID?
        $user = $this->getUser($param);
        if (!isset($user[0]['user_id'])) {
            return false;
        }
        try {
            $sql = "UPDATE users SET user_active = CASE WHEN user_active = 0 THEN 1 ELSE 0 END WHERE user_id = :user_id";
            $bind = array(
                ':user_id' => $param
            );
            $this->myDB->getArray($sql, $bind);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
   

    /**
     * getPasswort
     *
     * @param int $id
     * @return array
     */
    public function getPasswort(int $id): array {
        // User exists with this ID?
        $user = $this->getUser($id);
        if (!isset($user[0]['user_id'])) {
            return array();
        }
        try {
            $sql = "SELECT user_passwort FROM users WHERE user_id = :user_id";
            $bind = array(
                ':user_id' => $id
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