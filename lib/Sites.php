<?php
declare(strict_types=1);

namespace lib;
use Parsedown;

class Sites {
    public $html = '';
    public function __construct($folder = '', $subfolder = '',$file = 'Home') {
        $this->html = '';
        if ($folder != '' OR $folder != null) {
            if($subfolder != '' OR $subfolder != null){
                $SitesDir = BASEPATH."sites/".$folder."/".$subfolder."/"; 
            }else{
                $SitesDir = BASEPATH."sites/".$folder."/";
            }
        } else {
            $SitesDir = BASEPATH."sites/";
        }
        $this->html = $this->getFile($SitesDir.$file); 
    }
    public function getResponse(){
        if ($this->html != '') {
            $data = array();
            $data['main'] = $this->html;
            $data['session'] = $_SESSION;
            //echo '<pre>'.print_r($data).'</pre>';
            $index = new Template('index', $data);
            return $index->html;
        } else {
            return Error::response(404);
        }
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