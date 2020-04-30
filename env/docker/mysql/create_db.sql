use pizza_mysql;
CREATE TABLE IF NOT EXISTS `users` (
    `user_id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255),
    `password` varchar(255),
    `email` varchar(255),
    `primary_role` INTEGER
);

CREATE TABLE IF NOT EXISTS `roles` (
    `role_id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255),
    `description` varchar(255)
);

INSERT INTO `roles` (`name`, `description`) values ('admin', 'this is the main admin of the system');
INSERT INTO `users` (`name`, `email`, `password`, `primary_role`) values ('Admin','admin@admin.com', SHA1('admin'), 1);