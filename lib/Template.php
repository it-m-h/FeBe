<?php

declare(strict_types=1);

namespace lib;

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

/**
 * Template :: FeBe - Framework
 */
class Template {    
    /**
     * hbs
     *
     * @var Handlebars
     */
    public Handlebars $hbs;    
    /**
     * html
     *
     * @var string
     */
    public string $html;    
    /**
     * __construct
     *
     * @param  string $template
     * @param  array $data
     * @param  string $callback
     * @return void
     */
    public function __construct(string $template = 'index', array $data = array(), string $callback = 'render') {
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
    /**
     * render
     *
     * @param  string $template
     * @param  array $data
     * @return void
     */
    public function render(string $template, array $data): void {
        $this->html = $this->hbs->render($template, $data);
    }    
    /**
     * echo
     *
     * @param  string $template
     * @param  array $data
     * @return void
     */
    public function echo(string $template, array $data): void {
        echo $this->hbs->render($template, $data);
    }
}