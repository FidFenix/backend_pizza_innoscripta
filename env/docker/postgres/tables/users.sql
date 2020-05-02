BEGIN TRANSACTION;

CREATE TABLE users (
    user_id VARCHAR(256),
    email VARCHAR(256) UNIQUE NOT NULL,
    password VARCHAR(256),
    name VARCHAR(256),
    primary_role VARCHAR(256),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    modified_at TIMESTAMP,
    deleted_at TIMESTAMP,
    CONSTRAINT "user_id" PRIMARY KEY (user_id)
);

CREATE EXTENSION pgcrypto;

COMMIT;