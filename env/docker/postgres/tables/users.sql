BEGIN TRANSACTION;

CREATE TABLE users (
    user_id BIGINT,
    email VARCHAR(256) UNIQUE NOT NULL,
    password VARCHAR(256),
    name VARCHAR(256),
    primary_role VARCHAR(256),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    modified_at TIMESTAMP,
    deleted_at TIMESTAMP,
    CONSTRAINT "user_id" PRIMARY KEY (user_id)
)

CREATE EXTENSION pgcrypto;

INSERT INTO users(email, name, password, primary_role) values('admin@admin.com', 'Admin admin', crypt('admin', gen_salt('bf'), 1);
INSERT INTO users(email, name, password, primary_role) values('user@user.com', 'User', crypt('user', gen_salt('bf'), 1);


COMMIT;