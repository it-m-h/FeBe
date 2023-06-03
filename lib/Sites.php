<?php
declare(strict_types=1);

namespace lib;
use Parsedown;

class Sites {
    public $data = null;
    public $hbs = null;
    public $html = null;
    public function __construct($folder = '', $subfolder = '',$file = 'Home') {
        $this->data = array();
        if ($folder != '') {
            if($subfolder != ''){
                $SitesDir = BASEPATH."Sites/".$folder."/".$subfolder."/"; 
            }else{
                $SitesDir = BASEPATH."Sites/".$folder."/";
            }
        } else {
            $SitesDir = BASEPATH."Sites/";
        }

        $this->html = '';
        $this->html = $this->getFile($SitesDir.$file);

        /* if (file_exists($SitesDir.$file.'.md')) {
            $Parsedown = new Parsedown();
            $this->html =  $Parsedown->text(file_get_contents($SitesDir.$file.'.md'));
            
        } else if (file_exists($SitesDir.$file.'.html')) {
            $this->html = file_get_contents($SitesDir.$file.'.html');

        } else if (file_exists($SitesDir.$file.'.php')) {
            ob_clean();
            ob_start();
            include($SitesDir.$file.'.php');
            $this->html = ob_get_contents();
            ob_end_clean();
        } */
    }
    public function getFile($file){
        $html = '';
        if (file_exists($file.'.md')) {
            $Parsedown = new Parsedown();
            $html = $Parsedown->text(file_get_contents($file.'.md'));

        } else if (file_exists($file.'.html')) {
            $html = file_get_contents($file.'.html');

        } else if (file_exists($file.'.php')) {
            ob_clean();
            ob_start();
            include($file.'.php');
            $html = ob_get_contents();
            ob_end_clean();
        }
        return $html;
    }
}