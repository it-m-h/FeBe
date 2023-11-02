<h1>PHP - Parse</h1>
<?php

use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

$code = file_get_contents('./../app/User/Model.php');

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    //echo "Parse error: {$error->getMessage()}\n";
    return;
}

$dumper = new NodeDumper;
$prettyPrinter = new PrettyPrinter\Standard;

echo '<pre>';
//echo $dumper->dump($ast)."\n";
echo $prettyPrinter->prettyPrintFile($ast);
echo '</pre>';