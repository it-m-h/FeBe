<?php

declare(strict_types=1);

ini_set('session.use_strict_mode', 1);

// ---------------------------------------------------------------
// DEFINE constant Variables & LOAD Config
// ---------------------------------------------------------------
define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));
require BASEPATH.'config/config.php';

// ---------------------------------------------------------------
// Composer - PSR-4 - Autoloader
// ---------------------------------------------------------------
require BASEPATH.'vendor/autoload.php';

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