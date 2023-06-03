<?php
declare(strict_types=1);

namespace App;

abstract class App {

    public static function call($class = NULL, $method = 'run', $param = NULL) {
        if (class_exists($class)) {
            if ($method != NULL && method_exists($class, $method)) {
                $class = new $class($method, $param);
            } else {
                self::MethodError($method);
            }
        } else {
            self::ClassError($class);
        }
    }
    public static function MethodError($method = '') {
        http_response_code(404);
        header("HTTP/1.0 404 Not Found");
        $error = "<span>Error: </span><b>The server does not support the functionality required to fulfill the request.</b>";
        include BASEPATH.DS.'error'.DS.'404.php';
    }
    public static function ClassError($class = '') {
        http_response_code(404);
        header("HTTP/1.0 404 Not Found");
        $error = "<span>Error: </span><b>The server does not support the functionality required to fulfill the request.</b>";
        include BASEPATH.DS.'error'.DS.'404.php';
    }
}