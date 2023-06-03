<?php
declare(strict_types=1);

session_start();
if (!isset($_SESSION['Rights']))
    $_SESSION['Rights'] = 0;
if (!isset($_SESSION['Account']))
    $_SESSION['Account'] = null;
if (!isset($_SESSION['selectedAccount']))
    $_SESSION['selectedAccount'] = $_SESSION['Account'];

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
// CONFIG - Routes 
// ---------------------------------------------------------------
require BASEPATH.DS."config".DS.'router.php';

// ---------------------------------------------------------------
// Run the router
// ---------------------------------------------------------------
use Steampixel\Route;
Route::run('/');