<?php
use lib\Auth;
use lib\Response;
use lib\Sites;
use Steampixel\Route;

// -----------------------------------------------
// HOME
// -----------------------------------------------
Route::add('/', function () {
    $Sites = new Sites('', '', 'Home');
    echo $Sites->getResponse();
}, ['get']);


Route::add('/testRoute', function () {
    echo 'testRoute';
}, ['get']);


// -----------------------------------------------
// Account Login & Logout
// -----------------------------------------------
Route::add('/Account/Logout', function () {
    Auth::SessionRegenerate();
    header('Location: /');
}, ['get']);
Route::add('/Account/Login', function () {
    $file = 'Login';
    $Sites = new Sites('', '', $file);
    echo $Sites->getResponse();
}, ['get']);
Route::add('/Account/check', function () {
    if (empty($_POST['name']) || empty($_POST['password']) || strlen($_POST['name']) > 100 ||strlen($_POST['password']) > 255) {
        header('Location: /Account/Login');
    } else {
        $loginname = strip_tags($_POST['name']);
        $password = strip_tags($_POST['password']);
        if (Auth::chkLogin($loginname, $password)) {
            echo 1;
        } else {
            echo 0;
        }
    }
}, ['post']);

Route::add('/Account/check_old', function () {
    if (empty($_POST['name']) || empty($_POST['password'])) {
        header('Location: /Account/Login');
    }else{
        //php - cdde verhindern im post


        $loginname = $_POST['name'];
        $password = sha1($_POST['password']);
        if(Auth::chkLogin($loginname, $password)){
            header('Location: /Account/Account');
        } else {
            header('Location: /Account/Login');
        }
    }
}, ['post']);

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
    $Sites = new Sites('', '', $file);
    echo $Sites->getResponse();
}, ['get', 'post']);
Route::add('/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)', function ($folder, $file){
    $Sites = new Sites($folder, '', $file);
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