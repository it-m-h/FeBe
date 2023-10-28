<?php
if (!isset($_SESSION['Rights']) || $_SESSION['Rights'] !=1 ) header('Location: /');
?>

<h1>System</h1>

<?php

$info = new lib\System();
$handlebars = new Handlebars\Handlebars();

try {
    $template = file_get_contents(BASEPATH.'templates/Admin/System.hbs');
    if ($template === false) {
        echo 'Template konnte nicht geladen werden';
        exit;
    }
    echo $handlebars->render($template, $info->getInfo());

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
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}
