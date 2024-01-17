<?php

declare(strict_types=1);

namespace lib;

abstract class Cookie {
    public static function initCookie() {
        // Cookie setzen
        if (!isset($_COOKIE['FeBe'])) {
            $uniqueValue = uniqid('u_', true) .'_' . time().'_'.microtime(true);
            setcookie('FeBe', $uniqueValue, time() + (86400 * 300), "/");   
        }
        Cookie::checkVisitor();
    }
    public static function set(string $name = 'FeBe', $value = '', int $time = 86400) {
        setcookie($name, $value, time() + ($time * 300), "/");
    }

    public static function get(string $name = 'FeBe') {
        if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return false;
    }
    public static function checkVisitor() {
        $uniqueValue = '';
        if(!isset($_COOKIE['FeBe'])){
            $uniqueValue = uniqid('u_', true) .'_' . time().'_'.microtime(true);
            setcookie('FeBe', $uniqueValue, time() + (86400 * 300), "/");
        }else{
            $uniqueValue = $_COOKIE['FeBe'];
        }

        $db = new Database();
        $sql = "SELECT * FROM cookie WHERE cookie_name = '".$uniqueValue."'";
        $result = $db->getArray($sql);
        //echo '<pre>';
        //print_r($result);
        //echo '</pre>';
        if (count($result) == 0) {
            $sql = "INSERT INTO cookie ('cookie_name') VALUES ('".$uniqueValue."')";
            $db->run($sql);
            Cookie::writeDB('session_id', $_SESSION['client']['session_id']);
            Cookie::writeDB('ip', $_SESSION['client']['ip']);
            Cookie::writeDB('host', $_SESSION['client']['host']);
            Cookie::writeDB('browser', $_SESSION['client']['browser']);
            Cookie::writeDB('language', $_SESSION['client']['language']);
            Cookie::writeDB('time', $_SESSION['client']['time']);
            Cookie::writeDB('date', $_SESSION['client']['date']);
            Cookie::writeDB('time_zone', $_SESSION['client']['time_zone']);
            Cookie::writeDB('callingCode', $_SESSION['client']['reverse_lookup']['callingCode']);
            Cookie::writeDB('countryCapital', $_SESSION['client']['reverse_lookup']['countryCapital']);
            Cookie::writeDB('country_code', $_SESSION['client']['reverse_lookup']['country_code']);
            Cookie::writeDB('country_name', $_SESSION['client']['reverse_lookup']['country_name']);

            //expires
            $datetime = time() + (86400 * 300);
            $date = date('Y-m-d H:i:s', $datetime);
            Cookie::writeDB('expires', $date);
            //echo $sql;
        }
        $db = null;
        
    }

    public static function writeDB(string $field, $value) {
        Cookie::checkVisitor();
        $db = new Database();
        $sql = "UPDATE cookie SET ".$field." = '".$value."' WHERE cookie_name = '".$_COOKIE['FeBe']."'";
        $db->run($sql);
        $db = null;
    }
    public static function getVisitorData() {
        Cookie::checkVisitor();
        $db = new Database();
        $sql = "SELECT * FROM cookie WHERE cookie_name = '".$_COOKIE['FeBe']."'";
        $result = $db->getArray($sql);
        $db = null;
        return $result;
    }
}