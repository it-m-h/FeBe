<?php
declare(strict_types=1);

namespace App;
use lib\Response;

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
        Response::error(404);
    }
    public static function ClassError($class = '') {
        Response::error(404);
    }
}