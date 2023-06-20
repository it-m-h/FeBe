
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

INSERT INTO users (user_pfad, user_name, user_passwort, user_gruppe) VALUES ('admin', 'admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1);
INSERT INTO users (user_pfad, user_name, user_passwort, user_gruppe) VALUES ('user', 'user', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 2);
INSERT INTO users (user_pfad, user_name, user_passwort, user_gruppe) VALUES ('guest', 'guest', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 3);

CREATE TABLE IF NOT EXISTS settings (
	settings_id	INTEGER PRIMARY KEY AUTOINCREMENT,
	settings_name	TEXT,
	settings_value	TEXT,
	settings_bemerkung	TEXT,
	settings_group	TEXT
);

INSERT INTO settings (settings_id,settings_name,settings_value,settings_bemerkung,settings_group) VALUES 
 (1,'INFO','0','','global'),
 (2,'RESPONSECLEAR','0','','global'),
 (3,'APPNAME','FeBe',NULL,'global'),
 (4,'OWNER','info@it-master.ch','','global'),
 (5,'VERSION','1.0.0',NULL,'global'),
 (6,'CODE','localhost,CH,DE,AT,LI','Zugriff von welchen Ländern','country'),
 (7,'TITLE','FeBe',NULL,'head'),
 (8,'AUTHOR','it-master.ch',NULL,'head'),
 (9,'EDITOR','xxxxx',NULL,'head'),
 (10,'CONTENT_LANGUAGE','Deutsch',NULL,'head'),
 (11,'CONTENT_TYPE','xxxxx',NULL,'head'),
 (12,'CONTENT_SCRIPT-TYPE','xxxxx',NULL,'head'),
 (13,'PAGE_TYPE','xxxxx',NULL,'head'),
 (14,'PAGE_TOPIC','xxxxx',NULL,'head'),
 (15,'DESCRIPTION','xxxxx',NULL,'head'),
 (16,'KEYWORDS','xxxxx',NULL,'head'),
 (17,'COPYRIGHT','it-master.ch',NULL,'head'),
 (18,'DOMAIN','it-master.ch',NULL,'head'),
 (19,'ICONS','public/img/icons',NULL,'Public'),
 (20,'FOLDER','public/files',NULL,'Public'),
 (21,'EMAIL',NULL,NULL,'Mail'),
 (22,'NAME',NULL,NULL,'Mail'),
 (23,'HOST',NULL,NULL,'Mail'),
 (24,'SMTPAUTH',NULL,NULL,'Mail'),
 (25,'SMTPSECURE',NULL,NULL,'Mail'),
 (26,'USERNAME',NULL,NULL,'Mail'),
 (27,'PASSWORD',NULL,NULL,'Mail'),
 (28,'SSLPORT',NULL,NULL,'Mail'),
 (29,'NOSSLPORT',NULL,NULL,'Mail'),
 (30,'REPLYTO',NULL,NULL,'Mail'),
 (31,'SHOWNEWANDFORGOT','0','','login'),
 (32,'LOGINWITHCALC','0','','login'),
 (33,'LOGINWITH2FA','0','','login'),
 (34,'TWOFACTOR_DOMAIN','it-master.ch','','login');