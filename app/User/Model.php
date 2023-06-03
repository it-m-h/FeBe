<?php

declare(strict_types=1);

namespace App\User;
use League\Csv\Reader;
use lib\Database;

class Model {
    public $myDB = null;
    public function __construct($method = "run", $param = null) {
        $this->myDB = new Database();
    }
    public function getUsers() {
        $sql = 'Select * from users LEFT JOIN groups ON users.user_gruppe = groups.group_id ORDER BY user_active DESC, user_id ASC  ';
        return $this->myDB->getArray($sql);
    }
    public function getUser($id) {
        $sql = 'Select * from users LEFT JOIN groups ON users.user_gruppe = groups.group_id WHERE user_id = :id';
        $bind = array(':id' => $id);
        return $this->myDB->getArray($sql, $bind);
    }
    public function toggleUserStatus($param) {
        $sql = 'UPDATE users SET user_active = CASE WHEN user_active = 0 THEN 1 ELSE 0 END WHERE user_id = :user_id';
        $bind = array(
            ':user_id' => intval($param)
        );
        return $this->myDB->update($sql, $bind);
    }
    public function insertUser($param) {
        $sql = 'INSERT INTO users (user_pfad, user_name, user_passwort,user_gruppe, user_RFID) VALUES (:user_pfad, :user_name, :user_passwort, :user_gruppe, :user_RFID)';
        $bind = array(
            ':user_pfad' => $param['user_pfad'],
            ':user_name' => $param['user_name'],
            ':user_passwort' => sha1($param['user_passwort']),
            ':user_gruppe' => intval($param['user_gruppe']),
            ':user_RFID' => $param['user_RFID']
        );
        return $this->myDB->insert($sql, $bind);
    }
    public function updateUser($param) {
        $passwort = $this->getPasswort($param);
        if($passwort[0]['user_passwort'] == $param['user_passwort']) {
            $sql = 'UPDATE users SET user_pfad = :user_pfad, user_name = :user_name, user_gruppe = :user_gruppe, user_RFID = :user_RFID WHERE user_id = :user_id';
            $bind = array(
                ':user_pfad' => $param['user_pfad'],
                ':user_name' => $param['user_name'],
                ':user_gruppe' => intval($param['user_gruppe']),
                ':user_RFID' => $param['user_RFID'],
                ':user_id' => intval($param['user_id'])
            );
        } else {
            $sql = 'UPDATE users SET user_pfad = :user_pfad, user_name = :user_name, user_passwort = :user_passwort, user_gruppe = :user_gruppe, user_RFID = :user_RFID WHERE user_id = :user_id';
            $bind = array(
                ':user_pfad' => $param['user_pfad'],
                ':user_name' => $param['user_name'],
                ':user_passwort' => sha1($param['user_passwort']),
                ':user_gruppe' => intval($param['user_gruppe']),
                ':user_RFID' => $param['user_RFID'],
                ':user_id' => intval($param['user_id'])
            );
        }
        return $this->myDB->update($sql, $bind);
    }

    public function getPasswort($param) {
        $sql = 'Select user_passwort from users WHERE user_id = :user_id';
        $bind = array(
            ':user_id' => $param['user_id']
        );
        return $this->myDB->getArray($sql, $bind);
    }
    public function run() {
    }
    public function __destruct() {
        $this->myDB = null;
    }
}