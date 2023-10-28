<?php
declare(strict_types=1);

namespace lib;

/**
 * System :: FeBe - Framework
 */
class System {
    /**
     * info
     *
     * @var array
     */
    private $info = array();

    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        $this->Info_PHP();
        $this->Info_Sqlite3();
        $this->Info_Zip();
        $this->Info_Fileinfo();
        $this->Info_Pdo_Odbc();
        $this->Info_Pdo_Sqlite();
        $this->Info_Pdo_Mysql();
        $this->Info_Composer();
        $this->Info_Extensions();
        $this->Info_Config();
        $this->Info_Client();
        $this->Info_Session();
        $this->Info_Cookies();
        $this->Info_Defined();

    }

    /**
     * getInfo
     *
     * @return array
     */
    public function getInfo(): array {
        return $this->info;
    }

    /**
     * Info_PHP
     *
     * @return void
     */
    private function Info_PHP(): void {
        $this->info['chk']['phpversion']['txt'] = 'PHP-Version: '.phpversion().' (OK)';
        if (version_compare(phpversion(), '8.0.0') < 0) {
            $this->info['chk']['phpversion']['chk'] = false;
        } else {
            $this->info['chk']['phpversion']['chk'] = true;
        }
    }
    /**
     * Info_Sqlite3
     *
     * @return void
     */
    private function Info_Sqlite3(): void {
        $this->info['chk']['sqlite3']['txt'] = 'PHP-Extension: sqlite3';
        if (!extension_loaded('sqlite3')) {
            $this->info['chk']['sqlite3']['chk'] = false;
        } else {
            $this->info['chk']['sqlite3']['chk'] = true;
        }
    }
    /**
     * Info_Zip
     *
     * @return void
     */
    private function Info_Zip(): void {
        $this->info['chk']['zip']['txt'] = 'PHP-Extension: zip';
        if (!extension_loaded('zip')) {
            $this->info['chk']['zip']['chk'] = false;
        } else {
            $this->info['chk']['zip']['chk'] = true;
        }
    }

    /**
     * Info_Fileinfo
     *
     * @return void
     */
    private function Info_Fileinfo(): void {
        $this->info['chk']['fileinfo']['txt'] = 'PHP-Extension: fileinfo';
        if (!extension_loaded('fileinfo')) {
            $this->info['chk']['fileinfo']['chk'] = false;
        } else {
            $this->info['chk']['fileinfo']['chk'] = true;
        }
    }


    /**
     * Info_Pdo_Odbc
     *
     * @return void
     */
    private function Info_Pdo_Odbc(): void {
        $this->info['chk']['pdo_odbc']['txt'] = 'PHP-Extension: pdo_odbc';
        if (!extension_loaded('pdo_odbc')) {
            $this->info['chk']['pdo_odbc']['chk'] = false;
        } else {
            $this->info['chk']['pdo_odbc']['chk'] = true;
        }
    }

    /**
     * Info_Pdo_Sqlite
     *
     * @return void
     */
    private function Info_Pdo_Sqlite(): void {
        $this->info['chk']['pdo_sqlite']['txt'] = 'PHP-Extension: pdo_sqlite';
        if (!extension_loaded('pdo_sqlite')) {
            $this->info['chk']['pdo_sqlite']['chk'] = false;
        } else {
            $this->info['chk']['pdo_sqlite']['chk'] = true;
        }
    }

    /**
     * Info_Pdo_Mysql
     *
     * @return void
     */
    private function Info_Pdo_Mysql(): void {
        $this->info['chk']['pdo_mysql']['txt'] = 'PHP-Extension: pdo_mysql';
        if (!extension_loaded('pdo_mysql')) {
            $this->info['chk']['pdo_mysql']['chk'] = false;
        } else {
            $this->info['chk']['pdo_mysql']['chk'] = true;
        }
    }

    /**
     * Info_Composer
     *
     * @return void
     */
    private function Info_Composer(): void {
        $composerPath = shell_exec('composer --version'); // Pfade nach Composer suchen
        if (empty($composerPath)) {
            $this->info['chk']['composer']['txt'] = 'Composer ist NICHT installiert';
            $this->info['chk']['composer']['chk'] = false;
            $this->info['chk']['composer']['packages'] = false;
        } else {
            $this->info['chk']['composer']['txt'] = 'Composer ist installiert: '.$composerPath;
            $this->info['chk']['composer']['chk'] = true;
            //$this->info['chk']['composer']['packages'] = json_decode(file_get_contents(BASEPATH.'composer.json'), true)['require'];

            $composerLockContents = file_get_contents(BASEPATH.'composer.lock');
            if ($composerLockContents === false) {
                throw new \RuntimeException('Failed to read composer.lock');
            }
            $json = json_decode($composerLockContents, true);

            if (is_array($json) && isset($json['packages']) && is_array($json['packages'])) {
                foreach ($json['packages'] as $key => $value) {
                    $this->info['chk']['composer']['packages'][$key]['ver'] = $value['version'];
                    $this->info['chk']['composer']['packages'][$key]['name'] = $value['name'];
                    $this->info['chk']['composer']['packages'][$key]['info'] = $value['description'];
                    /* echo '<li>';
                    echo '<b>'.$value['name'].'</b> ('.$value['version'].')'.' <br> '.$value['description'].'';
                    echo '</b>'; */
                }
            } else {
                throw new \RuntimeException('Packages key is missing or is not an array.');
            }
        }
    }
    /**
     * Info_Extensions
     *
     * @return void
     */
    private function Info_Extensions(): void {
        $this->info['extensions']['txt'] = 'PHP-Extensions';
        $this->info['extensions']['val'] = get_loaded_extensions();
    }
    /**
     * Info_Config
     *
     * @return void
     */
    private function Info_Config(): void {
        $this->info['config']['txt'] = 'PHP-Config';
        $this->info['config']['val'] = ini_get_all();
    }
    /**
     * Info_Client
     *
     * @return void
     */
    private function Info_Client(): void {
        $this->info['client']['txt'] = 'Client';
        $this->info['client']['val'] = Request::client();
    }
    /**
     * Info_Session
     *
     * @return void
     */
    private function Info_Session(): void {
        $this->info['session']['txt'] = 'Session';
        $this->info['session']['val'] = $_SESSION;
    }
    /**
     * Info_Cookies
     *
     * @return void
     */
    private function Info_Cookies(): void {
        $this->info['cookies']['txt'] = 'Cookies';
        $this->info['cookies']['val'] = $_COOKIE;
    }
    /**
     * Info_Defined
     *
     * @return void
     */
    private function Info_Defined(): void {
        $this->info['defined']['txt'] = 'Defined';
        $this->info['defined']['val'] = get_defined_constants(true)['user'];
    }

}
