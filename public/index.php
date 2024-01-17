<?php

declare(strict_types=1);

ini_set('session.use_strict_mode', 1);

// ---------------------------------------------------------------
// DEFINE constant Variables & LOAD Config
// ---------------------------------------------------------------
define('DOMAIN', $_SERVER['HTTP_HOST']);
define('DS', DIRECTORY_SEPARATOR);
define('NEWLINE', "\r\n");
define('DELIMITER', ";"); // tab = \t
define('BASEPATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));
require BASEPATH.'config'.DS.'config.php';

// ---------------------------------------------------------------
// Composer - PSR-4 - Autoloader
// ---------------------------------------------------------------
require BASEPATH.'vendor'.DS.'autoload.php';

// ---------------------------------------------------------------
// Session - Start
// ---------------------------------------------------------------
\lib\Auth::SessionStart();
\lib\Request::client();

// ---------------------------------------------------------------
// Domain - initial 
// ---------------------------------------------------------------
lib\Domain::initDomain();

// ---------------------------------------------------------------
// CONFIGS 
// ---------------------------------------------------------------
$settings = new \lib\Database();
//$settings->setSettingsDefine();
if(!isset($_SESSION['settings'])){
    $_SESSION['settings'] = $settings->getSettings();
}

// ---------------------------------------------------------------
// Country - Block 
// ---------------------------------------------------------------
\lib\Request::checkCountry();

// ---------------------------------------------------------------
// CONFIG - Routes 
// ---------------------------------------------------------------
require BASEPATH.DS."config".DS.'router.php';

// ---------------------------------------------------------------
// Cookie - initial 
// ---------------------------------------------------------------
\lib\Cookie::initCookie();
//\lib\Cookie::writeDB('cookie_name', $_COOKIE['FeBe']);

/* $text = json_encode($_SESSION);
echo $text;
\lib\Cookie::writeDB('session_id', session_id());
\lib\Cookie::writeDB('value', ''); */

// ---------------------------------------------------------------
// Run the router
// ---------------------------------------------------------------
use Steampixel\Route;
use lib\Response;
if(isset($_SESSION['settings']['RESPONSECLEAR']) && $_SESSION['settings']['RESPONSECLEAR'] == 1){
    ob_clean();
    ob_start();
    $html = ob_get_contents();
    Response::sanitize_output($html);
    ob_end_clean();
    Route::run('/');
}else{
    Route::run('/');
}

