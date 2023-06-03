<?php
use lib\Sites;
use lib\Template;
use Steampixel\Route;


// -----------------------------------------------
// HOME
// -----------------------------------------------
Route::add('/', function () {
    $Sites = new Sites(null, null, 'Home');
    $data = array();
    $data['main'] = $Sites->html;
    $index = new Template('index', $data);
    echo $index->html;
}, ['get']);

// -----------------------------------------------
// Account Logout
// -----------------------------------------------
Route::add('/Account/Logout', function () {
    $_SESSION = array();
    session_destroy();
    $Sites = new Sites(null, null, 'Home');
    $data = array();
    $data['main'] = $Sites->html;
    $index = new Template('index', $data);
    echo $index->html;
}, ['get']);


// -----------------------------------------------
// Backend - APP - Router
// -----------------------------------------------
Route::add('/App/([a-zA-Z0-9]*)', function ($class) {
    $class = 'App\\'.$class.'\\'.$class;
    App\App::call($class);
}, ['get', 'post', 'put', 'delete']);
Route::add('/App/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)', function ($class, $method) {
    $class = 'App\\'.$class.'\\'.$class;
    App\App::call($class, $method);
}, ['get', 'post', 'put', 'delete']);
Route::add('/App/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)', function ($class, $method, $param) {
    $class = 'App\\'.$class.'\\'.$class;
    App\App::call($class, $method, $param);
}, ['get', 'post', 'put', 'delete']);


// -----------------------------------------------
// Frontend - Sites Routings
// -----------------------------------------------
Route::add('/([a-zA-Z0-9]*)', function ($file){
    $Sites = new Sites(null, null, $file);
    $data = array();
    $data['main'] = $Sites->html;
    $index = new Template('index', $data);
    echo $index->html;
}, ['get', 'post']);
Route::add('/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)', function ($folder, $file){
    $Sites = new Sites($folder, null, $file);
    $data = array();
    $data['main'] = $Sites->html;
    $index = new Template('index', $data);
    echo $index->html;
}, ['get', 'post']);
Route::add('/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)', function ($subfolder, $folder, $file) {
    $Sites = new Sites($folder, $subfolder, $file);
    $data = array();
    $data['main'] = $Sites->html;
    $index = new Template('index', $data);
    echo $index->html;
}, ['get', 'post']);



// -----------------------------------------------
// Site Routings :: ANY
// -----------------------------------------------
Route::pathNotFound(function ($path) {
    http_response_code(404);
    header("HTTP/1.0 404 Not Implemented");
    $error = "<span>Error: </span><b>The server does not support the functionality required to fulfill the request.</b>";
    include(BASEPATH.'error/404.php');
});