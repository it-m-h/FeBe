<?php
declare(strict_types=1);

session_start();
if (!isset($_SESSION['Rights']))
    $_SESSION['Rights'] = 0;
if (!isset($_SESSION['Account']))
    $_SESSION['Account'] = null;
if (!isset($_SESSION['selectedAccount']))
    $_SESSION['selectedAccount'] = $_SESSION['Account'];

$data = array();

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

use lib\Sites;
use Steampixel\Route;

// ---------------------------------------------------------------
// LOAD LAYOUT
// ---------------------------------------------------------------
// Navigation load
$Sites = new Sites('Nav');
$data['nav'] = $Sites->html;
// Footer load
$Sites = new Sites('Footer');
$data['footer'] = $Sites->html;
// Header load
$Sites = new Sites('Header');
$data['header'] = $Sites->html;


// ---------------------------------------------------------------
// Run the router
// ---------------------------------------------------------------
Route::run('/');