<?php

declare(strict_types=1);

namespace lib;

abstract class Auth {
    public static function chkLogin($loginname, $password){
        $myDB = new Database();
        $sql = "SELECT * FROM users LEFT JOIN groups ON users.user_gruppe = groups.group_id  WHERE user_name = :user_name AND user_passwort = :user_passwort";
        $bind = array(
            ':user_name' => $loginname,
            ':user_passwort' => $password
        );
        $result = $myDB->getArray($sql, $bind);
        if (is_array($result) && count($result) == 1) {
            $_SESSION = $result[0];
            $_SESSION['Rights'] = $result[0]['group_rights'];
            return true;
        } else {
            return false;
        }
    }
}