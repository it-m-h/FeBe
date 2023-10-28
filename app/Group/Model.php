<?php

declare(strict_types=1);

namespace App\Group;

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
     * getGroups
     *
     * @return array<array<string, mixed>>
     */
    public function getGroups(): array {
        try {
            $sql = "SELECT * FROM groups";
            return $this->myDB->getArray($sql);
        } catch (\PDOException $e) {
            return array();
        }
    }
    /**
     * getGroup
     *
     * @param  int $id
     * @return array<array<string, mixed>>
     */
    public function getGroup(int $id): array {
        try {
            $sql = "SELECT * FROM groups WHERE group_id = :group_id";
            $bind = array(
                ':group_id' => $id
            );
            return $this->myDB->getArray($sql, $bind);
        } catch (\Exception $e) {
            return array();
        }
    }
    /**
     * insert
     *
     * @param array{
     *  group_name: string,
     *  group_rights: int
     * } $param
     * @return bool
     */
    public function insert(array $param): bool {
        try {
            $sql = "INSERT INTO groups (group_name, group_rights) VALUES (:group_name, :group_rights)";
            $bind = array(
                ':group_name' => $param['group_name'],
                ':group_rights' => $param['group_rights']
            );
            $this->myDB->insert($sql, $bind);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
    /**
     * update
     *
     * @param array{
     *  group_name: string,
     *  group_rights: int,
     *  group_id: int
     * } $param
     * @return bool
     */
    public function update(array $param): bool {
        try {
            $sql = "UPDATE groups SET group_name = :group_name, group_rights = :group_rights WHERE group_id = :group_id";
            $bind = array(
                ':group_name' => $param['group_name'],
                ':group_rights' => $param['group_rights'],
                ':group_id' => $param['group_id']
            );
            $this->myDB->update($sql, $bind);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
    /**
     * toggleGroupStatus
     *
     * @param  int $param
     * @return bool
     */
    public function toggleGroupStatus(int $param): bool {
        try {
            $sql = "UPDATE groups SET group_active = CASE WHEN group_active = 0 THEN 1 ELSE 0 END WHERE group_id = :group_id";
            $bind = array(
                ':group_id' => $param
            );
            $this->myDB->update($sql, $bind);
            return true;
        } catch (\Exception $e) {
            return false;
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