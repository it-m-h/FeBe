# FeBe
FeBe - Front-End, Back-End, MVC, PHP - Framework.
Ist in Moment in der Entwicklung .....

![FeBe - Framework](/public/img/febe/001.jpg "FeBe - Framework")


### Front-End
Implementierung von Funktionen und die Darstellung von Inhalten, mit HTML, CSS, JavaScript. Es wird das Materialize CSS verwendet, JQuery sowie JS-Handlebars und JS-Code Highlight.

### Back-End
Logik, Datenverarbeitung und Datenbankinteraktion. Das Back-End ist für die Verarbeitung von Benutzeranfragen, die Bereitstellung von Daten und die Kommunikation mit dem Front-End verantwortlich. Es werden verschiedene Cpmposer-Packages verwendet und SQLITE3. 
Über PHP-PDO wird die Datenbank angesprochen. Somit ist es möglich, auch andere Datenbanken zu verwenden. Die Templates werden mit PHP - Handlebars gerendert.

### FeBe - Framework
Das PHP-Framework ist eine Sammlung von Bibliotheken, Werkzeugen und vorgefertigtem Code, die die Entwicklung von Webanwendungen mit PHP vereinfachen sollen. Es bietet eine Struktur und einen Satz von Regeln, um die Entwicklung effizienter, skalierbarer und wartbarer Anwendungen zu erleichtern. 

# Installation:

## mit Composer:
```bash
composer create-project it-m-h/FeBe testFebe --stability=dev
```

# Server - Konfiguration:

## FeBe vHost in XAMPP
PHP : C:\xampp\php\php.ini

### folgende PHP-Module müssen aktiviert sein:
- extension=pdo_sqlite
- extension=sqlite3
- extension=zip

## FeBe vHost in XAMPP
PHP : C:\xampp\php\php.ini

### rudimentäre Konfig, zum Testen
```
LISTEN 55001
<VirtualHost *:55001>
    DocumentRoot "C:\xampp\htdocs\testFebe\public"
</VirtualHost>
```
Aufruf im Browser: http://localhost:55001/

### opimalere Konfig, ev. auch über DNS - Name:  Seite1.local
vHosts : C:\xampp\apache\conf\extra\httpd-vhosts.conf
```
<VirtualHost *:80>
    Servername Seite1.local
    DocumentRoot "C:\xampp\htdocs\FeBe\public"
    ErrorLog "logs/Seite1.local-error.log"
    CustomLog "logs/Seite1.local-access.log" common
    <Directory "C:\xampp\htdocs\FeBe\public">
        Options Indexes FollowSymLinks Includes ExecCGI
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Aufruf im Browser: http://Seite1.local/

### Info: 
- Nach dem Ändern der httpd.conf muss der Apache-Server neu gestartet werden.
- Die Datei httpd.conf muss eventuell als Administrator geöffnet werden.
- die httpd-vhosts.conf wäre natürlich besser geeignet für Virtuelle Hots, aber die httpd.conf ist die Hauptdatei.
- im Windows kann auch mit der Hosts-Datei gearbeitet werden, um DNS-Namen zu vergeben. (für den lokalen Rechner), die Hosts-Datei befindet sich unter: C:\Windows\System32\drivers\etc\hosts