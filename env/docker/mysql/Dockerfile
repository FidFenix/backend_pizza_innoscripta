FROM mysql:latest

ENV MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
ENV MYSQL_USER=${MYSQL_USER}
ENV MYSQL_PASSWORD=${MYSQL_PASSWORD}

ENV MYSQL_DATA_DIR=/var/lib/mysql \
    MYSQL_RUN_DIR=/run/mysqld \
    MYSQL_LOG_DIR=/var/log/mysql

ADD ["./create_db.sql", "/tmp/dump.sql"]
# Copy the database schema to the /data directory
# ADD ./run_db.sh ./init_db.sh ./create_db.sql /tmp/

# init_db will create the default
# database from epcis_schema.sql, then
# stop mysqld, and finally copy the /var/lib/mysql directory
# to default_mysql_db.tar.gz
#RUN /etc/init.d/mysql start
#RUN which mysql
#RUN sudo chown -R mysql:mysql /var/lib/mysql /var/run/mysqld
#RUN /usr/bin/mysql start
#RUN mysql -u root -p${MYSQL_ROOT_PASSWORD} < /tmp/dump.sql

# run_db starts mysqld, but first it checks
# to see if the /var/lib/mysql directory is empty, if
# it is it is seeded with default_mysql_db.tar.gz before
# the mysql is fired up

#  ENTRYPOINT "/tmp/run_db.sh"
EXPOSE 3306