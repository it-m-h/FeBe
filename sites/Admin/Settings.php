<?php

if (!isset($_SESSION['Rights']) || $_SESSION['Rights'] != 1)
    header('Location: /');

use App\Settings\Settings;
use Handlebars\Handlebars;

$settings = new Settings();
$handlebars = new Handlebars();


try{
    $template = file_get_contents(BASEPATH.'templates/Admin/Settings.hbs');
    if ($template === false) {
        echo 'Template konnte nicht geladen werden';
        exit;
    }
    echo $handlebars->render(
        $template,
        $settings->getSettingsGroup()
    );
}catch(\Exception $e){
    echo $e->getMessage();
    exit;
}

    


