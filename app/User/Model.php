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
     *  @return array<array<string, mixed>>
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
     * @return array<array<string, mixed>>
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
     * @return array<void>[]
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