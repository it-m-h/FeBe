<?php

if (!isset($_SESSION['Rights']) || $_SESSION['Rights'] != 1)
    header('Location: /');

use App\Settings\Settings;
use Handlebars\Handlebars;

$settings = new Settings();
$handlebars = new Handlebars();

$template =  file_get_contents(BASEPATH.'templates/Admin/Settings.hbs');
echo $handlebars->render(
        $template, $settings->getSettingsGroup()
);
