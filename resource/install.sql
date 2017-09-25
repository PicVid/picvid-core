-- entities
CREATE TABLE `image` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` TEXT,
  `filename` VARCHAR(255) NOT NULL DEFAULT '',
  `size` INT UNSIGNED NOT NULL DEFAULT 0,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `type` VARCHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE = INNODB;

CREATE TABLE `user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL DEFAULT '',
  `firstname` VARCHAR(255) NOT NULL DEFAULT '',
  `lastname` VARCHAR(255) NOT NULL DEFAULT '',
  `password` CHAR(128) NOT NULL DEFAULT '',
  `salt` CHAR(128) NOT NULL DEFAULT '',
  `username` VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE = INNODB;

CREATE TABLE `session` (
  `id` VARCHAR(32) NOT NULL DEFAULT '',
  `content` TEXT NOT NULL,
  `create_time` INT UNSIGNED NOT NULL DEFAULT 0,
  `user_agent` VARCHAR(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE = INNODB;

-- mapping tables
CREATE TABLE `user_image` (
  `user_id` INT UNSIGNED NOT NULL DEFAULT 0,
  `image_id` INT UNSIGNED NOT NULL DEFAULT 0,
  FOREIGN KEY (`user_id`) REFERENCES user(`id`),
  FOREIGN KEY (`image_id`) REFERENCES image(`id`),
  CONSTRAINT pk_user_image PRIMARY KEY (`user_id`, `image_id`)
) ENGINE = INNODB;