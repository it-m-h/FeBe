<?php
declare(strict_types=1);

ini_set('session.use_strict_mode', 1);

session_start();

use Steampixel\Route;
use lib\Response;

// ---------------------------------------------------------------
// DEFINE constant Variables & LOAD Config
// ---------------------------------------------------------------
define('DOMAIN', $_SERVER['HTTP_HOST']);
define('DS', DIRECTORY_SEPARATOR);
define('NEWLINE', "\r\n");
define('DELIMITER', ";"); // tab = \t
// wett public in $_SERVER['DOCUMENT_ROOT']
if(strpos($_SERVER['DOCUMENT_ROOT'], 'public') !== false){
    define('BASEPATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));
}elseif(strpos($_SERVER['DOCUMENT_ROOT'], 'html') !== false){
    define('BASEPATH', str_replace('html', '', $_SERVER['DOCUMENT_ROOT']));
}else{
    define('BASEPATH', $_SERVER['DOCUMENT_ROOT']);
}
// ---------------------------------------------------------------
// Composer - PSR-4 - Autoloader
// ---------------------------------------------------------------
require BASEPATH.'vendor'.DS.'autoload.php';

// ---------------------------------------------------------------
// Check - Server & PHP extension
// ---------------------------------------------------------------
require 'check.php';
$check = new check();
if (!$check() && !$_SESSION['checkSrv']) {
    exit();
}

// ---------------------------------------------------------------
// Applikation - Configs
// ---------------------------------------------------------------
//define('BASEPATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));
require BASEPATH.'config'.DS.'config.php';

// ---------------------------------------------------------------
// Session - Start
// ---------------------------------------------------------------
\lib\Auth::SessionStart();
\lib\Request::client();

// ---------------------------------------------------------------
// CONFIGS 
// ---------------------------------------------------------------
$settings = new \lib\Database();
//$settings->setSettingsDefine();
if (!isset($_SESSION['settings'])) {
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
// \lib\Cookie::initCookie();
// \lib\Cookie::writeDB('cookie_name', $_COOKIE['FeBe']);

/* $text = json_encode($_SESSION);
echo $text;
\lib\Cookie::writeDB('session_id', session_id());
\lib\Cookie::writeDB('value', ''); */

// ---------------------------------------------------------------
// Run the router
// ---------------------------------------------------------------

if (isset($_SESSION['settings']['RESPONSECLEAR']) && $_SESSION['settings']['RESPONSECLEAR'] == 1) {
    ob_clean();
    ob_start();
    $html = ob_get_contents();
    Response::sanitize_output($html);
    ob_end_clean();
    Route::run('/');
} else {
    Route::run('/');
}
