<h1>Home</h1>

<p>
  Hello World! 
</p>

<hr>

<?php

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
  echo '$_SESSION: ';
  echo '<pre>';
  print_r($_SESSION);
  echo '</pre>';
}


if(defined('DB_FILE')){
  echo 'SQLite3 Database: ';
  echo DB_FILE;
  echo '<br>';
}


if (defined('DB_HOST')) {
  echo 'MySQL Database: ';
  echo DB_HOST;
  echo '<br>';
}
