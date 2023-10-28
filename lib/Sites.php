<?php
declare(strict_types=1);

namespace lib;

use Parsedown;

/**
 * Sites :: FeBe - Framework
 */
class Sites {
    /**
     * html
     *
     * @var string
     */
    public $html = '';
    /**
     * __construct
     *
     * @param  string $folder
     * @param  string $subfolder
     * @param  string $file
     * @return void
     */
    public function __construct(string $folder = '', string $subfolder = '', string $file = 'Home') {
        $SitesDir = BASEPATH."sites/";
        if ($folder !== '') {
            $SitesDir .= $folder.'/';
            if ($subfolder !== '') {
                $SitesDir .= $subfolder.'/';
            }
        }
        $this->html = $this->getFile($SitesDir.$file);
    }
    /**
     * getResponse
     *
     * @return string html response
     */
    public function getResponse(): string {
        if (!empty($this->html)) {
            $data = [
                'main' => $this->html,
                'session' => $_SESSION
            ];
            $index = new Template('index', $data);
            return $index->html;
        }
        return Error::response(404);
    }
    /**
     * getFile
     *
     * @param  string $file
     * @return string
     */
    public function getFile(string $file): string {
        if (file_exists($file.'.md')) {
            $Parsedown = new Parsedown();
            return $Parsedown->text(file_get_contents($file.'.md'));
        }
        if (file_exists($file.'.html')) {
            $content = file_get_contents($file.'.html');
            return ($content === false) ? '' : $content;
        }
        if (file_exists($file.'.php')) {
            if (ob_get_level()) {
                ob_clean();
            }
            ob_start();
            include($file.'.php');
            $output = ob_get_clean();
            return ($output === false) ? '' : $output;
        }
        return '';
    }
}