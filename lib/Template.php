<?php

declare(strict_types=1);

namespace lib;

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

class Template {
    public $hbs = null;
    public $html = null;
    public function __construct($template = 'index', $data = array(), $callback = 'render') {
        $TemplateDir = BASEPATH."templates/";
        $TemplateLoader = new FilesystemLoader(
            $TemplateDir,
            [
                "extension" => "hbs"
            ]
        );
        $PartialsDir = BASEPATH."templates/partials/";
        $PartialsLoader = new FilesystemLoader(
            $PartialsDir,
            [
                "extension" => "hbs"
            ]
        );
        $this->hbs = new Handlebars([
            "loader" => $TemplateLoader,
            "partials_loader" => $PartialsLoader
        ]);

        $this->hbs->addHelper('Rights', function ($template, $context, $args, $source) {
            $result = '';
            if (!isset($_SESSION['Rights']))
                $_SESSION['Rights'] = 0;
            if ($_SESSION['Rights'] == $args) {
                $result = $template->render($context);
            } 
            return $result;
        });

        $this->hbs->addHelper('isAdmin', function ($template, $context, $args, $source) {
            $result = '';
            if (!isset($_SESSION['Rights'])) $_SESSION['Rights'] = 0;
            if ($_SESSION['Rights'] == 1) {
                $result = $template->render($context);
            }
            return $result;
        });
        $this->hbs->addHelper('isLoggedIn', function ($template, $context, $args, $source) {
            $result = '';
            if (!isset($_SESSION['Rights']))
                $_SESSION['Rights'] = 0;
            if ($_SESSION['Rights'] > 0) {
                $result = $template->render($context);
            }
            return $result;
        });

        $this->{$callback}($template, $data);
    }
    public function render($template, $data) {
        $this->html = $this->hbs->render($template, $data);
    }
    public function echo($template, $data) {
        echo $this->hbs->render($template, $data);
    }
}