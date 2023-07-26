<?php
declare(strict_types=1);

namespace lib;

class System {
    private $info = array();

    /* constructor */
    public function __construct(){
        $this->Info_PHP();
        $this->Info_Sqlite3();
        $this->Info_Zip();
        $this->Info_Composer();
        $this->Info_Extensions();
        $this->Info_Config();
        $this->Info_Client();
        $this->Info_Session();
        $this->Info_Cookies();
        $this->Info_Defined();

    }
    public function getInfo(){
        return $this->info;
    }

    private function Info_PHP(){
        $this->info['chk']['phpversion']['txt'] = 'PHP-Version: ' . phpversion() . ' (OK)';
        if (version_compare(phpversion(), '8.0.0') < 0) {
            $this->info['chk']['phpversion']['chk'] = false;
        } else {
            $this->info['chk']['phpversion']['chk'] = true;
        }
    }
    private function Info_Sqlite3(){
        $this->info['chk']['sqlite3']['txt'] = 'PHP-Extension: sqlite3';
        if (!extension_loaded('sqlite3')) {
            $this->info['chk']['sqlite3']['chk'] = false;
        } else {
            $this->info['chk']['sqlite3']['chk'] = true;
        }
    }
    private function Info_Zip(){
        $this->info['chk']['zip']['txt'] = 'PHP-Extension: zip';
        if (!extension_loaded('zip')) {
            $this->info['chk']['zip']['chk'] = false;
        } else {
            $this->info['chk']['zip']['chk'] = true;
        }
    }
    private function Info_Composer(){
        $composerPath = shell_exec('composer --version'); // Pfade nach Composer suchen
        if (empty($composerPath)) {
            $this->info['chk']['composer']['txt'] = 'Composer ist NICHT installiert';
            $this->info['chk']['composer']['chk'] = false;
            $this->info['chk']['composer']['packages'] = false;
        } else {
            $this->info['chk']['composer']['txt'] = 'Composer ist installiert: ' . $composerPath;
            $this->info['chk']['composer']['chk'] = true;
            //$this->info['chk']['composer']['packages'] = json_decode(file_get_contents(BASEPATH.'composer.json'), true)['require'];

            $composerLockContents = file_get_contents(BASEPATH.'composer.lock');
            $json = json_decode($composerLockContents, true);
            foreach ($json['packages'] as $key => $value) {

                $this->info['chk']['composer']['packages'][$key]['ver']= $value['version'];
                $this->info['chk']['composer']['packages'][$key]['name']= $value['name'];
                $this->info['chk']['composer']['packages'][$key]['info']= $value['description'];


                /* echo '<li>';
                echo '<b>'.$value['name'].'</b> ('.$value['version'].')'.' <br> '.$value['description'].'';
                echo '</b>'; */
            }


        }
    }

    private function Info_Extensions(){
        $this->info['extensions']['txt'] = 'PHP-Extensions';
        $this->info['extensions']['val'] = get_loaded_extensions();
    }
    private function Info_Config(){
        $this->info['config']['txt'] = 'PHP-Config';
        $this->info['config']['val'] = ini_get_all();
    }
    private function Info_Client(){
        $this->info['client']['txt'] = 'Client';
        $this->info['client']['val'] = Request::client();
    }
    private function Info_Session(){
        $this->info['session']['txt'] = 'Session';
        $this->info['session']['val'] = $_SESSION;
    }
    private function Info_Cookies(){
        $this->info['cookies']['txt'] = 'Cookies';
        $this->info['cookies']['val'] = $_COOKIE;
    }
    private function Info_Defined(){
        $this->info['defined']['txt'] = 'Defined';
        $this->info['defined']['val'] = get_defined_constants(true)['user'];
    }

}
