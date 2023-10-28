<?php

declare(strict_types=1);

namespace lib;

/**
 * Auth :: FeBe - Framework
 */
abstract class Auth {    
    /**
     * chkLogin
     *
     * @param  string $loginname
     * @param  string $password
     * @return bool
     */
    public static function chkLogin(string $loginname, string $password): bool{
        try {
            $myDB = new Database();
            $sql = "SELECT * FROM users LEFT JOIN groups ON users.user_gruppe = groups.group_id  WHERE user_name = :user_name AND user_passwort = :user_passwort";
            $bind = array(
                ':user_name' => $loginname,
                ':user_passwort' => $password
            );
            /** @var array<mixed> $result */
            $result = $myDB->getArray($sql, $bind);
            if (is_array($result) && count($result) == 1) {
                Auth::SessionRegenerate();
                $_SESSION = $result[0];
                $_SESSION['Rights'] = $result[0]['group_rights'];
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
    /**
     * isLoggedIn
     *
     * @return bool
     */
    public static function isLoggedIn(): bool {
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] > 0) {
            return true;
        } else {
            return false;
        }
    }    
    /**
     * chkRights
     *
     * @param  int $rights
     * @return bool
     */
    public static function chkRights(int $rights): bool{
        // 0 = Admin
        // 5 = User
        // 9 = Gast
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] <= $rights && $_SESSION['Rights'] != 0) {
            return true;
        } else {
            return false;
        }
    }    
    /**
     * initRights
     *
     * @param  int $rights
     * @return void
     */
    public static function initRights(int $rights): void {
        if (!isset($_SESSION['Rights']))
            $_SESSION['Rights'] = 0;
        if ($_SESSION['Rights'] < 1 || !Auth::chkRights($rights))
            header('Location: /');
    }
    /**
     * isAdmin
     *
     * @return bool
     */
    public static function isAdmin(): bool{
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] == 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * isGuest
     *
     * @return bool
     */
    public static function isGuest(): bool{
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] == 9) {
            return true;
        } else {
            return false;
        }
    }  
    /**
     * isUser
     *
     * @return bool
     */
    public static function isUser(): bool{
        if (isset($_SESSION['Rights']) && $_SESSION['Rights'] == 5) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * SessionStart
     *
     * @return void
     */
    public static function SessionStart() {
        session_start();
        if(!defined('DURATION')){
            define('DURATION', 600);
        }
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
    /**
     * SessionRegenerate
     *
     * @return void
     */
    public static function SessionRegenerate() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $newid = session_create_id('FeBe-');
        if ($newid === false) {
            return;
        }
        session_commit();
        ini_set('session.use_strict_mode', 0);
        session_id($newid);
        session_start();
        $_SESSION['deleted_time'] = time();
    }
}