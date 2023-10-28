<?php
declare(strict_types=1);
namespace lib;

/**
 * Response :: FeBe - Framework
 */
abstract class Response {    
    /**
     * header
     *
     * @return array
     */
    public static function header(): array {
        $headers = apache_response_headers();
        return $headers;
    }    
    /**
     * json
     *
     * @param  array $response
     * @return void
     */
    public static function json(array $response): void {
        http_response_code(200);
        header("HTTP/1.0 200 Not Found");
        header('Content-Type: application/json');
        echo json_encode($response);
    }    
    /**
     * html
     *
     * @param  string $response
     * @return void
     */
    public static function html(string $response): void {
        http_response_code(200);
        header("HTTP/1.0 200 Not Found");
        header('Content-Type: text/html');
        echo $response;
    }
    
    /**
     * error
     *
     * @param  int $code
     * @return void
     */
    public static function error(int $code = 404): void {
        http_response_code($code);
        header("HTTP/1.0 ".$code." Not Found");
        $error = "<span>Error: </span><b>The server does not support the functionality required to fulfill the request.</b>";
        include BASEPATH.DS.'error'.DS.$code.'.php';
    }
        
    /**
     * sanitize_output
     *
     * @param  string $buffer
     * @return void
     */
    public static function sanitize_output(string $buffer): void {
        echo $buffer . "<!-- Sanitized -->";
    }
}