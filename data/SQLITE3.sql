
CREATE TABLE IF NOT EXISTS groups(
    group_id INTEGER PRIMARY KEY AUTOINCREMENT,
    group_name TEXT(255) NOT NULL,
    group_rights INTEGER(1) NOT NULL DEFAULT 9,
    group_createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    group_active INT(1) NOT NULL DEFAULT 1
);

INSERT INTO groups (group_name, group_rights) VALUES ('Administratoren', 1);
INSERT INTO groups (group_name, group_rights) VALUES ('Mitarbeiter', 5);
INSERT INTO groups (group_name, group_rights) VALUES ('Gäste', 9);

CREATE TABLE IF NOT EXISTS users(
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_name TEXT(255) NOT NULL,
    user_pfad TEXT(255) NOT NULL,
    user_passwort TEXT(255) NOT NULL,
    user_gruppe INTEGER(1) NOT NULL DEFAULT 3,
    user_RFID TEXT(255),
    user_createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_active INT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (user_gruppe) REFERENCES groups(group_id)
);

INSERT INTO users (user_pfad, user_name, user_passwort, user_gruppe) VALUES ('admin', 'admin', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 1);
INSERT INTO users (user_pfad, user_name, user_passwort, user_gruppe) VALUES ('user', 'user', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 2);
INSERT INTO users (user_pfad, user_name, user_passwort, user_gruppe) VALUES ('guest', 'guest', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 3);

CREATE TABLE IF NOT EXISTS settings (
	settings_id	INTEGER PRIMARY KEY AUTOINCREMENT,
	settings_name	TEXT,
	settings_value	TEXT,
	settings_bemerkung	TEXT,
	settings_group	TEXT
);

INSERT INTO settings (settings_name,settings_value,settings_bemerkung,settings_group) VALUES 
 ('INFO','0','','global'),
 ('RESPONSECLEAR','0','','global'),
 ('APPNAME','FeBe',NULL,'global'),
 ('OWNER','info@it-master.ch','','global'),
 ('VERSION','1.0.0',NULL,'global'),
 ('CODE','localhost,CH,DE,AT,LI','Zugriff von welchen Ländern','country'),
 ('LANG','de-CH',NULL,'head'),
 ('IE','IE=edge',NULL,'head'),
 ('VIEWPORT','width=device-width, initial-scale=1.0',NULL,'head'),
 ('CONTENT_TYPE','text/html; charset=UTF-8',NULL,'head'),
 ('ROBOTS','index,follow',NULL,'head'),
 ('ROBOTS_REVISIT','10 days',NULL,'head'),
 ('LANGUAGE','german',NULL,'head'),
 ('MOBILE','yes',NULL,'head'),
 ('THEME_COLOR','black',NULL,'head'),
 ('TITLE','FeBe',NULL,'head'),
 ('KEYWORDS','xxxxx',NULL,'head'),
 ('DESCRIPTION','xxxxx',NULL,'head'),
 ('AUTHOR','it-master.ch',NULL,'head'),
 ('PUBLISHER','it-master.ch',NULL,'head'),
 ('COPYRIGHT','it-master.ch',NULL,'head'),
 ('ICONS','public/img/icons',NULL,'Public'),
 ('FOLDER','public/files',NULL,'Public'),
 ('EMAIL',NULL,NULL,'Mail'),
 ('NAME',NULL,NULL,'Mail'),
 ('HOST',NULL,NULL,'Mail'),
 ('SMTPAUTH',NULL,NULL,'Mail'),
 ('SMTPSECURE',NULL,NULL,'Mail'),
 ('USERNAME',NULL,NULL,'Mail'),
 ('PASSWORD',NULL,NULL,'Mail'),
 ('SSLPORT',NULL,NULL,'Mail'),
 ('NOSSLPORT',NULL,NULL,'Mail'),
 ('REPLYTO',NULL,NULL,'Mail'),
 ('SHOWNEWANDFORGOT','0','','login'),
 ('LOGINWITHCALC','0','','login'),
 ('LOGINWITH2FA','0','','login'),
 ('TWOFACTOR_DOMAIN','it-master.ch','','login');

 CREATE TABLE IF NOT EXISTS "cookie" (
    "id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    "created"	DATETIME DEFAULT (datetime('now', 'localtime')),
    "expires"	DATETIME,
    "cookie_name"	TEXT,
    "value"	TEXT,
    "session_id"	TEXT,
    "ip"	TEXT,
    "host"	TEXT,
    "browser"	TEXT,
    "language"	TEXT,
    "time"	TEXT,
    "date"	TEXT,
    "time_zone"	TEXT,
    "callingCode"	TEXT,
    "countryCapital"	TEXT,
    "country_code"	TEXT,
    "country_name"	TEXT,
    "aktiv"	INT DEFAULT 1
);


-- View mit allen usern und Gruppen
CREATE VIEW IF NOT EXISTS user_view AS
SELECT *
FROM users
INNER JOIN groups ON users.user_gruppe = groups.group_id;
