<?php
declare(strict_types=1);
namespace lib;

abstract class Response {
    public static function header() {
        $headers = apache_response_headers();
        return $headers;
    }
    public static function json($response) {
        http_response_code(200);
        header("HTTP/1.0 200 Not Found");
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public static function html($response) {
        http_response_code(200);
        header("HTTP/1.0 200 Not Found");
        header('Content-Type: text/html');
        echo $response;
    }

    public static function error($code = 404) {
        http_response_code($code);
        header("HTTP/1.0 ".$code." Not Found");
        $error = "<span>Error: </span><b>The server does not support the functionality required to fulfill the request.</b>";
        include BASEPATH.DS.'error'.DS.$code.'.php';
    }
    
    public static function sanitize_output($buffer){
        echo $buffer . "<!-- Sanitized -->";
    }
}