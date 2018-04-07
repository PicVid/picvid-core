-- entities
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL DEFAULT '',
  `firstname` VARCHAR(255) NOT NULL DEFAULT '',
  `lastname` VARCHAR(255) NOT NULL DEFAULT '',
  `password` VARCHAR(128) NOT NULL DEFAULT '',
  `salt` VARCHAR(128) NOT NULL DEFAULT '',
  `username` VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` VARCHAR(32),
  `access` INT UNSIGNED,
  `data` TEXT,
  `user_agent` VARCHAR(255),
  PRIMARY KEY(`id`)
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `images` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` TEXT,
  `filename` VARCHAR(255) NOT NULL DEFAULT '',
  `size` INT UNSIGNED NOT NULL DEFAULT 0,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `type` VARCHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE = INNODB;

-- mapping tables
CREATE TABLE IF NOT EXISTS `users_images` (
  `users_id` INT UNSIGNED NOT NULL DEFAULT 0,
  `images_id` INT UNSIGNED NOT NULL DEFAULT 0,
  FOREIGN KEY (`users_id`) REFERENCES users(`id`),
  FOREIGN KEY (`images_id`) REFERENCES images(`id`),
  CONSTRAINT pk_users_images PRIMARY KEY (`users_id`, `images_id`)
) ENGINE = INNODB;