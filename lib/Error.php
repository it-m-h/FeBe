<?php

declare(strict_types=1);

namespace lib;

/**
 * Error :: FeBe - Framework
 */
abstract class Error{
    
    /**
     * response
     *
     * @param  int $code
     * @return string
     */
    public static function response($code = 404): string{
        ob_clean();
        ob_start();
        http_response_code($code);
        header("HTTP/1.0 ".$code." Not Implemented");
        $error = "<span>Error: </span><b>The server does not support the functionality required to fulfill the request.</b>";
        include(BASEPATH.'error/'.$code.'.php');
        $html = (string) ob_get_contents();
        ob_end_clean();
        return $html;
    }
}