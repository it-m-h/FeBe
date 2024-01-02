<?php
declare(strict_types=1);
namespace lib;
use Exception;

/**
 * Request :: FeBe - Framework
 */
abstract class Request {
    
    /**
     * header
     *
     * @return array Associative array of the request headers
     */
    public static function header(): array {
        $headers = apache_request_headers();
        return $headers;
    }    
    /**
     * client
     *
     * @return array Associative array client information
     */
    public static function client(): array {
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
            if ($ch === false) {
                throw new Exception("Failed to initialize cURL session.");
            }
            $init = '{"callingCode":"41","city":"","countryCapital":"Bern","country_code":"CH","country_name":"Switzerland","currency":"CHE,CHF,CHW","currencySymbol":"CHF","emojiFlag":"🇨🇭","flagUrl":"https://ip-api.io/images/flags/ch.svg","ip":"162.23.130.190","is_in_european_union":false,"latitude":47.1449,"longitude":8.1551,"metro_code":0,"organisation":"Swiss Federation represented by FOITT","region_code":"","region_name":"","suspiciousFactors":{"isProxy":false,"isSpam":false,"isSuspicious":false,"isTorNode":false},"time_zone":"Europe/Zurich","zip_code":""}';
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $apiResponse = curl_exec($ch);
            curl_close($ch);
            // Check if the cURL request failed.
            if ($apiResponse === false) {
                $apiResponse = $init;
            }
            // Decode the JSON response. Adding true as the second argument to json_decode() ensures you get an array instead of an object.
            if (is_string($apiResponse)) {
                $result = (array)json_decode($apiResponse, true);
            } else {
                // If not a string, use the default JSON string.
                $result = (array)json_decode($init, true); // Your default JSON string.
            }
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
    /**
     * checkCountry
     *
     * @return void
     */
    public static function checkCountry():void {
        $country = $_SESSION['client']['reverse_lookup']['country_code'];
        $allow = $_SESSION['settings']['CODE'];
        if (stripos($allow, $country) == false) {
            Response::error(404);
            exit;
        }
    }
    
    /**
     * request
     *
     * @param  string $url
     * @param  string $method
     * @param  array $data
     * @return array
     */
    public static function OpenURL(string $url, string $method = 'GET', array $data = array()) :array {

        $_SERVER['REQUEST_METHOD'] = $method;
        $apiURL = "http://FeBe.local/".$url;
        $ch = curl_init($apiURL);
        if ($ch === false) {
            throw new Exception("Failed to initialize cURL session.");
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'FeBe-PHPUnit-Testing/1.0');

        // Prüfe, ob die Methode POST ist und übergebe die Daten
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $apiResponse = curl_exec($ch);
        if ($apiResponse === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($apiResponse, 0, $header_size);
        $body = substr($apiResponse, $header_size);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        return array(
            'header_size' => $header_size,
            'header' => $header,
            'body' => $body,
            'status_code' => $status_code
        );
    }


}