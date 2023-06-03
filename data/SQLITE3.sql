
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
