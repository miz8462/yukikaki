DROP TABLE IF EXISTS yukikaki_logs;

CREATE TABLE yukikaki_logs (
    id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    time INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET=utf8mb4;
