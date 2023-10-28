<?php
declare(strict_types=1);

namespace App;
use lib\Response;

/**
 * App :: FeBe - Framework
 */
abstract class App {
    
    /**
     * call
     *
     * @param  ?string $class
     * @param  ?string $method
     * @param  ?string $param
     * @return void
     */
    public static function call(?string $class = NULL, ?string $method = 'run', ?string $param = NULL) {
        if ($class != NULL && class_exists($class)) {
            if ($method != NULL && method_exists($class, $method)) {
                $class = new $class($method, $param);
            } else {
                self::MethodError($method);
            }
        } else {
            self::ClassError($class);
        }
    }    
    /**
     * MethodError
     *
     * @param  ?string $method
     * @return void
     */
    public static function MethodError(?string $method = '') {
        Response::error(404);
    }    
    /**
     * ClassError
     *
     * @param  ?string $class
     * @return void
     */
    public static function ClassError(?string $class = '') {
        Response::error(404);
    }
}