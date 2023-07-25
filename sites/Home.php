<h1>Home</h1>

<p>
  Hello World!
</p>

<?php

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
