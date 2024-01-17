<?php
// ---------------------------------------------------------------
// DEBUG - show Errors true or false
// ---------------------------------------------------------------
define('DEBUG', true);
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
} else {
    error_reporting(0);
    ini_set("display_errors", 0);
}

// ---------------------------------------------------------------
// Country code and language
// ---------------------------------------------------------------
date_default_timezone_set("Europe/Paris");
//setlocale(LC_TIME, 'de_DE.UTF-8', 'de_DE@euro', 'de_DE', 'de-DE', 'de', 'ge', 'de_DE.UTF-8', 'German');
setlocale(LC_TIME, 'de_CH.utf8', 'de_CH', 'deu_ch', 'Swiss');

// ---------------------------------------------------------------
// Server Settings
// ---------------------------------------------------------------
@ini_set('memory_limit', '32M');

// ---------------------------------------------------------------
// SESSION LEASE TIME IN SECONDS
// ---------------------------------------------------------------
define('DURATION', 600);

// ---------------------------------------------------------------
// Applikation Settings
// ---------------------------------------------------------------
//define('DOMAIN', 'http://FeBe.local');

//define('DOMAIN', $_SERVER['HTTP_HOST']);

// ---------------------------------------------------------------
// CONFIG - FILES & FOLDERS (coming soon)
// ---------------------------------------------------------------
// define('FOLDER', 'public/Files');


// ---------------------------------------------------------------
// CONFIG - DATABASE (comming soon)
// ---------------------------------------------------------------
// SQLITE3 - DATABASE   
define('DB_FILE', BASEPATH.'data'.DS.'FeBe.sqlite3');


// mysql - DATABASE 
/* 
define('DB_HOST', 'localhost');
define('DB_NAME', 'febe');
define('DB_USER', 'root');
define('DB_PASS', ''); 
*/

// ---------------------------------------------------------------
// CONFIG - CSV (coming soon)
// ---------------------------------------------------------------
/* 
define('USERS', BASEPATH.'Data/users.csv');
define('GROUPS', BASEPATH.'Data/groups.csv');
define('CSV_DELIMITER', ';'); // tab = \t
define('CSV_NEWLINE', "\r\n");
define('HEADERLINE', true); 
*/

