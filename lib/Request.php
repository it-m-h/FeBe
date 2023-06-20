<?php
declare(strict_types=1);
namespace lib;

abstract class Request {

    public static function header() {
        $headers = apache_request_headers();
        return $headers;
    }
    public static function client() {
        if (!isset($_SESSION['client'])) {
            $info = array();
            $info['ip'] = $_SERVER['REMOTE_ADDR'];
            $info['host'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $info['browser'] = $_SERVER['HTTP_USER_AGENT'];
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
                $info['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            isset($_SERVER['HTTP_REFERER']) ? $info['referer'] = $_SERVER['HTTP_REFERER'] : '';

            $info['method'] = $_SERVER['REQUEST_METHOD'];
            $info['protocol'] = $_SERVER['SERVER_PROTOCOL'];
            $info['uri'] = $_SERVER['REQUEST_URI'];
            $info['query'] = $_SERVER['QUERY_STRING'];
            $info['time'] = $_SERVER['REQUEST_TIME'];
            $info['time_local'] = $_SERVER['REQUEST_TIME_FLOAT'];
            $info['time_zone'] = date_default_timezone_get();
            if ($info['ip'] == '::1' or $info['ip'] == '127.0.0.1' or $info['ip'] == 'localhost') {
                // Bluewin DNS - Server
                $info['ip'] = '195.186.1.110';
            }
            $apiURL = "https://ip-api.io/json/".$info['ip'];
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $apiResponse = curl_exec($ch);
            if (!is_array($apiResponse))
                $apiResponse = '{"callingCode":"41","city":"","countryCapital":"Bern","country_code":"CH","country_name":"Switzerland","currency":"CHE,CHF,CHW","currencySymbol":"CHF","emojiFlag":"🇨🇭","flagUrl":"https://ip-api.io/images/flags/ch.svg","ip":"162.23.130.190","is_in_european_union":false,"latitude":47.1449,"longitude":8.1551,"metro_code":0,"organisation":"Swiss Federation represented by FOITT","region_code":"","region_name":"","suspiciousFactors":{"isProxy":false,"isSpam":false,"isSuspicious":false,"isTorNode":false},"time_zone":"Europe/Zurich","zip_code":""}';
            curl_close($ch);
            $result = (array)json_decode($apiResponse);
            if (json_last_error() === JSON_ERROR_NONE) {
                // JSON is valid
                $info['reverse_lookup'] = $result;
            } else {
                // JSON is invalid
                $info['reverse_lookup'] = 'no GeoInfo';
            }
            $_SESSION['client'] = $info;
        }else{
            $info = $_SESSION['client'];
        }
        return $info;
    }
    public static function checkCountry() {
        $country = $_SESSION['client']['reverse_lookup']['country_code'];
        $allow = $_SESSION['settings']['CODE'];
        if (stripos($allow, $country) == false) {
            Response::error(404);
            exit;
        }
    }
}