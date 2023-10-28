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
        $this->html = '';
        if ($folder != '') {
            if($subfolder != ''){
                $SitesDir = BASEPATH."sites/".$folder."/".$subfolder."/"; 
            }else{
                $SitesDir = BASEPATH."sites/".$folder."/";
            }
        } else {
            $SitesDir = BASEPATH."sites/";
        }
        $this->html = $this->getFile($SitesDir.$file); 
    }    
    /**
     * getResponse
     *
     * @return string html response
     */
    public function getResponse(): string{
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
    /**
     * getFile
     *
     * @param  string $file
     * @return string
     */
    public function getFile(string $file): string{
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