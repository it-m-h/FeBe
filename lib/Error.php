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
        switch ($code) {
            case 404:
                $error = "<span>Error: </span><b>Not Found</b>";
                break;
            case 501:
                $error = "<span>Error: </span><b>The server does not support the functionality required to fulfill the request.</b>";
                break;
        }
        $errorPagePath = BASEPATH.'error/'.$code.'.php';
        if (file_exists($errorPagePath)) {
            include($errorPagePath);
        } else {
            echo "<span>Error: </span><b>Not Found</b>";
        }
        $html = (string) ob_get_contents();
        ob_end_clean();
        return $html;
    }
}