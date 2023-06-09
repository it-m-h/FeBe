# FeBe
FeBe - Front-End, Back-End, MVC, PHP - Framework.
Further information can be found in the "UseFeBe" menu in FeBe.

![FeBe - Framework](/public/img/febe/001.jpg "FeBe - Framework")


### FrontEnd
Implementation of functions and presentation of content, with HTML, CSS, JavaScript. Materialize CSS is used, 
JQuery as well as JS handlebars and JS code highlight.

### BackEnd
Logic, data processing and database interaction. The backend is responsible for processing user requests, providing data, and communicating with the frontend. Different Cpmposer packages are used and SQLITE3. The database connection is established using PHP-PDO. It is therefore possible to use other databases as well. The templates are rendered with PHP handlebars.

### FeBe - Framework
The PHP framework is a collection of libraries, tools, and pre-built code designed to simplify the development of web applications using PHP. It provides a structure and set of rules to facilitate the development of efficient, scalable, and maintainable applications.

# Installation:
Composer is required to install the dependencies.

## Composer:
```bash
composer create-project it-m-h/FeBe testFebe --stability=dev
```

## GIT:
```bash
git clone https://github.com/it-m-h/FeBe
cd FeBe
composer update
```

After that, navigate to the directory and configure the .gitignore file (exclude data, sites, and config).
Update: To fetch the latest version.
```bash
git pull 
```

## ZIP-Datei, Download from GitHub:
Download the ZIP file and extract its contents.
```bash
cd goToFolderFrom_FeBe
composer update
```

# Server - Configuration:

## FeBe vHost in XAMPP
PHP : C:\xampp\php\php.ini

### The following PHP modules need to be enabled:

- extension=pdo_sqlite
- extension=sqlite3
- extension=zip

## FeBe vHost in XAMPP
PHP : C:\xampp\php\php.ini

### rudimentary configuration for testing purposes:
```
LISTEN 55001
<VirtualHost *:55001>
    DocumentRoot "C:\xampp\htdocs\testFebe\public"
</VirtualHost>
```
Browser: http://localhost:55001/

### Optimal configuration, possibly using a DNS name: Page1.local.
vHosts : C:\xampp\apache\conf\extra\httpd-vhosts.conf
```
<VirtualHost *:80>
    Servername Page1.local
    DocumentRoot "C:\xampp\htdocs\FeBe\public"
    ErrorLog "logs/Page1.local-error.log"
    CustomLog "logs/Page1.local-access.log" common
    <Directory "C:\xampp\htdocs\FeBe\public">
        Options Indexes FollowSymLinks Includes ExecCGI
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Browser: http://Page1.local/

### Info: 
- After modifying the httpd.conf file, the Apache server needs to be restarted.
- The httpd.conf file may need to be opened as an administrator.
- The httpd-vhosts.conf file is more suitable for virtual hosts, but the httpd.conf file is the main configuration file.
- In Windows, the hosts file can also be used to assign DNS names (for the local machine). The hosts file is located at: C:\Windows\System32\drivers\etc\hosts.