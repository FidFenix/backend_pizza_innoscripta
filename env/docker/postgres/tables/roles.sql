BEGIN TRANSACTION;

CREATE TABLE roles (
    role_id BIGINT,
    name VARCHAR(256) UNIQUE NOT NULL,
    description VARCHAR(256),
    CONSTRAINT "role_id" PRIMARY KEY (role_id)
);

INSERT INTO roles(name, description) values('admin', 'this is the admin of the system');
INSERT INTO roles(name, description) values('user', 'this is the user of the system');

COMMIT;