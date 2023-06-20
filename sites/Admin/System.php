<?php
if (!isset($_SESSION['Rights']) || $_SESSION['Rights'] !=1 ) header('Location: /');
?>

<h1>System</h1>

<?php
echo '<h3>HTTP-RequestHeader</h3>';
echo '<pre><code class="lang:array hljs language-txt">';
print_r(lib\Request::header());
echo '</code></pre>';

echo '<h3>HTTP-ResponseHeader</h3>';
echo '<pre><code class="lang:array hljs language-txt">';
print_r(lib\Response::header());
echo '</code></pre>';

/* echo '<h3>Client</h3>';
echo '<pre><code class="lang:array hljs language-txt">';
print_r(lib\Request::client());
echo '</code></pre>'; */
/************************************************************************** SYSTEM - CHECK */
echo '<h3>System - Check</h3>';
// php version
// falls php kleiner als 8 st fehler ausgeben
if (version_compare(phpversion(), '8.0.0') < 0) {
    echo '<b>PHP-Version: </b>'.phpversion().' <b style="color:red;">(Fehler, Update wird empfholen)</b><br>';
} else {
    echo '<b>PHP-Version: </b>'.phpversion().' <b style="color:green;">(OK)</b><br>';
}
// falls sqlite3 nicht installiert ist fehler ausgeben
if (!extension_loaded('sqlite3')) {
    echo '<b>PHP-Extension: </b>sqlite3 <b style="color:red;">(Fehler, bitte php.ini anpassen)</b><br>';
} else {
    echo '<b>PHP-Extension: </b>sqlite3 <b style="color:green;">(OK)</b><br>';
}
if (!extension_loaded('zip')) {
    echo '<b>PHP-Extension: </b>zip <b style="color:red;">(Fehler, bitte php.ini anpassen)</b><br>';
} else {
    echo '<b>PHP-Extension: </b>zip <b style="color:green;">(OK)</b><br>';
}

// falls composer nicht auf dem rechner ist
$composerPath = shell_exec('composer --version'); // Pfade nach Composer suchen
if (empty($composerPath)) {
    echo '<b>Composer ist NICHT installiert: </b> <b style="color:red;">(Fehler, bitte composer installieren)</b><br>';
} else {
    echo '<b>Composer ist installiert: </b>'.$composerPath.' <b style="color:green;">(OK)</b><br>';
}

// php extensions
/* echo '<b>PHP-Extensions: </b><br>';
echo '<pre><code class="lang:array hljs language-txt">';
print_r(get_loaded_extensions());
echo '</code></pre>'; */

// php ini
/* echo '<b>PHP-Config: </b><br>';
echo '<pre><code class="lang:array hljs language-txt">';
print_r(ini_get_all());
echo '</code></pre>';
 */


/************************************************************************** COMPOSER - PACKAGES */
// Lade den Inhalt der composer.lock-Datei
$composerLockContents = file_get_contents(BASEPATH.'composer.lock');

// string in array
$json = json_decode($composerLockContents, true);

echo '<h3>Installed Composer - Packages</h3>';
echo '<ul class="browser-default">';
foreach ($json['packages'] as $key => $value) {
    echo '<li>';
    echo '<b>'.$value['name'].'</b> ('.$value['version'].')'.' <br> '.$value['description'].'';
    echo '</b>';
}
echo '</ul>';

