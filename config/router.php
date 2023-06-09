<?php
use lib\Response;
use lib\Sites;
use Steampixel\Route;

// -----------------------------------------------
// HOME
// -----------------------------------------------
Route::add('/', function () {
    $Sites = new Sites(null, null, 'Home');
    echo $Sites->getResponse();
}, ['get']);

// -----------------------------------------------
// Account Logout
// -----------------------------------------------
Route::add('/Account/Logout', function () {
    $_SESSION = array();
    session_destroy();
    $Sites = new Sites(null, null, 'Home');
    echo $Sites->getResponse();
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
    echo $Sites->getResponse();
}, ['get', 'post']);
Route::add('/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)', function ($folder, $file){
    $Sites = new Sites($folder, null, $file);
    echo $Sites->getResponse();
}, ['get', 'post']);
Route::add('/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)', function ($subfolder, $folder, $file) {
    $Sites = new Sites($folder, $subfolder, $file);
    echo $Sites->getResponse();
}, ['get', 'post']);

// -----------------------------------------------
// Site Routings :: ANY
// -----------------------------------------------
Route::pathNotFound(function ($path) {
    //echo Error::response(404);
    Response::error(404);
});