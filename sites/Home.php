<h1>Home</h1>

<p>
  Hello World! 
</p>

<hr>

<?php


echo "<h3>URL: ".$_SERVER['HTTP_HOST']." </h3>";
echo "<p> Datenbank: ". DB_FILE;
echo "<br>Verscheidene URL können auch verschiedene DB's verwenden :: config/config.php</p>";
echo '<hr>';

if (isset($_COOKIE['FeBe'])) {
  echo '<b>VISITOR - DATA: </b>';
  echo '<br>';
  echo '$_COOKIE["FeBe"]: '.$_COOKIE['FeBe'];
  echo '<br>';
  echo '<pre>';
  print_r(\lib\Cookie::getVisitorData());
  echo '</pre>';
  echo '<hr>';
}




if ($_SESSION) {
  echo '<h3>$_SESSION: </h3>';
  echo '<pre>';
  print_r($_SESSION);
  echo '</pre>';
}


if(isset($_SESSION['DB'])){
  echo '<h3>SQLite3 Database: </h3>';
  echo $_SESSION['DB'];
  echo '<br>';
}


if (defined('DB_HOST')) {
  echo '<h3>MySQL Database: </h3>';
  echo DB_HOST;
  echo '<br>';
}
