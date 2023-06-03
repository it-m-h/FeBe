<?php

declare(strict_types=1);

namespace App\Group;

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
    public function getGroups() {
        $sql = "SELECT * FROM groups";
        return $this->myDB->getArray($sql);
    }
    public function getGroup($param = null) {
        $sql = "SELECT * FROM groups WHERE group_id = " . $param;
        return $this->myDB->getArray($sql);
    }
    public function insert($param = NULL) {
        $sql = 'INSERT INTO groups (group_name, group_rights) VALUES (:group_name, :group_rights)';
        $bind = array(
            ':group_name' => $param['group_name'],
            ':group_rights' => intval($param['group_rights'])
        );
        return $this->myDB->insert($sql, $bind);
    }
    public function update($param = NULL) {
        $sql = 'UPDATE groups SET group_name = :group_name, group_rights = :group_rights WHERE group_id = :group_id';
        $bind = array(
            ':group_name' => $param['group_name'],
            ':group_rights' => intval($param['group_rights']),
            ':group_id' => intval($param['group_id'])
        );
        return $this->myDB->update($sql, $bind);
    }
    public function toggleGroupStatus($param = NULL) {
        $sql = 'UPDATE groups SET group_active = CASE WHEN group_active = 0 THEN 1 ELSE 0 END WHERE group_id = :group_id';
        $bind = array(
            ':group_id' => intval($param)
        );
        return $this->myDB->update($sql, $bind);
    }
    public function run() {
    }
    public function __destruct() {
        $this->myDB = null;
    }
}