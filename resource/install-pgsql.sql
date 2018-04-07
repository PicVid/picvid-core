-- entities
CREATE TABLE IF NOT EXISTS "users" (
  id BIGSERIAL PRIMARY KEY,
  email VARCHAR(255) NOT NULL DEFAULT '',
  firstname VARCHAR(255) NOT NULL DEFAULT '',
  lastname VARCHAR(255) NOT NULL DEFAULT '',
  password VARCHAR(128) NOT NULL DEFAULT '',
  salt VARCHAR(128) NOT NULL DEFAULT '',
  username VARCHAR(100) NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS "sessions" (
  id VARCHAR(32) PRIMARY KEY,
  access INT,
  data TEXT,
  user_agent VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS "images" (
  id BIGSERIAL PRIMARY KEY,
  description TEXT,
  filename VARCHAR(255) NOT NULL DEFAULT '',
  size INT NOT NULL DEFAULT 0,
  title VARCHAR(255) NOT NULL DEFAULT '',
  type VARCHAR(20) NOT NULL DEFAULT ''
);

-- mapping tables
CREATE TABLE IF NOT EXISTS "users_images" (
  users_id INT NOT NULL DEFAULT 0 REFERENCES users(id),
  images_id INT NOT NULL DEFAULT 0 REFERENCES images(id),
  PRIMARY KEY (users_id, images_id)
);