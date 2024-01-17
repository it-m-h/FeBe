<?php
class check{

    public function __invoke(){
        $_SESSION['checkSrv'] = true;
        
        if (!version_compare(PHP_VERSION, '8.0', '>')) {
            //exit('PHP8.0+ Required');
            echo 'PHP8.0+ required<br>';
            $_SESSION['checkSrv'] = false;
        }
        // curl - check
        if (!function_exists('curl_init')) {
            //exit('CURL Required');
            echo 'PHP: extension=curl required<br>';
            $_SESSION['checkSrv'] = false;
        } 
        // PDO - mit mysql check
        if (!extension_loaded('pdo_mysql')) {
            //exit('PDO Required');
            echo 'PHP: extension=pdo_mysql required<br>';
            $_SESSION['checkSrv'] = false;
        }
        // PDO - mit sqlite3 check
        if (!extension_loaded('pdo_sqlite')) {
            //exit('PDO Required');
            echo 'PHP: extension=pdo_sqlite required<br>';
            $_SESSION['checkSrv'] = false;
        }
        // sqlite3 - check
        if (!extension_loaded('sqlite3')) {
            //exit('ZIP Required');
            echo 'PHP: extension=sqlite3 required<br>';
            $_SESSION['checkSrv'] = false;
        } 
        // zip - check
        if (!extension_loaded('zip')) {
            //exit('SQLite3 Required');
            echo 'PHP: extension=zip required<br>';
            $_SESSION['checkSrv'] = false;
        }  
        // extension=fileinfo
        if (!extension_loaded('fileinfo')) {
            //exit('SQLite3 Required');
            echo 'PHP: extension=fileinfo required<br>';
            $_SESSION['checkSrv'] = false;
        }

        // rechte auf data - ordner
        if (!is_writable(BASEPATH.DS.'data')) {
            //exit('SQLite3 Required');
            echo 'PHP: data folder and files must be writable<br>';
            $_SESSION['checkSrv'] = false;
        }
                

        // check: composer
        if (!file_exists(BASEPATH.'vendor/autoload.php')) {
            //exit('SQLite3 Required');
            echo 'Composer: composer must be installed<br>';
            $_SESSION['checkSrv'] = false;
        }
        // check: erusev/parsedown
        if (!file_exists(BASEPATH.'vendor/erusev/parsedown')) {
            //exit('SQLite3 Required');
            echo 'Composer: erusev/parsedown must be installed<br>';
            $_SESSION['checkSrv'] = false;
        }
        // check:  salesforce/handlebars-ph
        if (!file_exists(BASEPATH.'vendor/salesforce/handlebars-php')) {
            //exit('SQLite3 Required');
            echo 'Composer: salesforce/handlebars-php must be installed<br>';
            $_SESSION['checkSrv'] = false;
        }

        // check: scrivo/highlight.php
        if (!file_exists(BASEPATH.'vendor/scrivo/highlight.php')) {
            //exit('SQLite3 Required');
            echo 'Composer: scrivo/highlight.php must be installed<br>';
            $_SESSION['checkSrv'] = false;
        }

        // check: steampixel/simple-php-router
        if (!file_exists(BASEPATH.'vendor/steampixel/simple-php-router')) {
            //exit('SQLite3 Required');
            echo 'Composer: steampixel/simple-php-router must be installed<br>';
            $_SESSION['checkSrv'] = false;
        }

        // check: vlucas/valitron
        if (!file_exists(BASEPATH.'vendor/vlucas/valitron')) {
            //exit('SQLite3 Required');
            echo 'Composer: vlucas/valitron must be installed<br>';
            $_SESSION['checkSrv'] = false;
        }


        
        if(!$_SESSION['checkSrv']){
            $info = new lib\System();
            /* echo '<pre>';
            print_r($info->getInfo());
            echo '</pre>'; */
            $template = file_get_contents(BASEPATH.'templates/Admin/System.hbs');
            $handlebars = new Handlebars\Handlebars();
            echo $handlebars->render($template, $info->getInfo());
        }
        return $_SESSION['checkSrv'];
    }
}
