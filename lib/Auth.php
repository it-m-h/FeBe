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
            Auth::SessionRegenerate();
            $_SESSION = $result[0];
            $_SESSION['Rights'] = $result[0]['group_rights'];
            return true;
        } else {
            return false;
        }
    }

    public static function isLoggedIn() {
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] > 0) {
            return true;
        } else {
            return false;
        }
    }
    public static function chkRights(int $rights){
        // 0 = Admin
        // 5 = User
        // 9 = Gast
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] <= $rights) {
            return true;
        } else {
            return false;
        }
    }

    public static function isAdmin(){
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] == 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function isGuest(){
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] == 9) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function isUser(){
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] == 5) {
            return true;
        } else {
            return false;
        }
    }

    public static function SessionStart() {
        session_start();
        if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - DURATION) {
            session_destroy();
            session_start();
        }
        if (!isset($_SESSION['Rights']))
            $_SESSION['Rights'] = 0;
        if (!isset($_SESSION['Account']))
            $_SESSION['Account'] = null;
        if (!isset($_SESSION['selectedAccount']))
            $_SESSION['selectedAccount'] = $_SESSION['Account'];
        if ($_SESSION['Rights'] > 0) {
            $_SESSION['deleted_time'] = time();
        }
    }

    public static function SessionRegenerate() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $newid = session_create_id('FeBe-');
        session_commit();
        ini_set('session.use_strict_mode', 0);
        session_id($newid);
        session_start();
        $_SESSION['deleted_time'] = time();
    }


}