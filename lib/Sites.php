<?php
declare(strict_types=1);

namespace lib;
use Parsedown;

class Sites {
    public $hbs = null;
    public $html = null;
    public function __construct($folder = '', $subfolder = '',$file = 'Home') {
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
        if (file_exists($SitesDir.$file.'.md')) {
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
        }
    }
}