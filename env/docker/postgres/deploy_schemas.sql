--- Deploy fresh databases

\i '/docker-entrypoint-initdb.d/tables/roles.sql'
\i '/docker-entrypoint-initdb.d/tables/users.sql'