<h1>Home</h1>

<?php

echo 'Hello World!';
echo '<h3>HTTP-Requestheader</h3>';
echo '<pre>';
print_r(lib\Request::header());
echo '</pre>';

echo '<h3>HTTP-Responseheader</h3>';
echo '<pre>';
print_r(lib\Response::header());
echo '</pre>';

echo '<h3>Client</h3>';
echo '<pre>';
print_r(lib\Request::client());
echo '</pre>';;
