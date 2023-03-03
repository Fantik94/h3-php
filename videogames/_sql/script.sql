DROP DATABASE IF EXISTS videogames; 

CREATE DATABASE videogames;

CREATE TABLE videogames.game (
  id MEDIUMINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  description TEXT,
  release_date DATE,
  poster VARCHAR(255),
  price DECIMAL(5,2)
);

INSERT INTO videogames.game (id, title, description, release_date, poster, price) VALUES
(NULL, 'Super Mario Bros', 'Jeu video de plateforme', '1985-09-13', 'https://example.com/super-mario-bros.jpg', 59.99),
(NULL, 'The Legend of Zelda: Ocarina of Time', 'Jeu video d\'action-aventure', '1998-11-23', 'https://example.com/zelda-ocarina-of-time.jpg', 49.99),
(NULL, 'Grand Theft Auto V', 'Jeu video d\'action-aventure', '2013-09-17', 'https://example.com/gta5.jpg', 29.99);

CREATE TABLE videogames.admin (
  id TINYINT PRIMARY KEY,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255)
);

INSERT INTO videogames.admin (id, email, password)
VALUES (1, 'test@test.fr', '$argon2i$v=19$m=16,t=2,p=1$WXAwMkU2OGtSRngwNDFaSQ$iGwjcHC+ZXzJZg5bqp9fIw');

CREATE TABLE videogames.editor (
  id TINYINT PRIMARY KEY,
  name VARCHAR(255)
);

INSERT INTO videogames.editor (id, name) VALUES
  (1, 'Nintendo'),
  (2, 'Rockstar'),
  (3, 'Activision Blizzard');

ALTER TABLE videogames.game
ADD COLUMN editor_id TINYINT AFTER price,
ADD FOREIGN KEY (editor_id) REFERENCES editor(id);

CREATE TABLE videogames.category (
  id TINYINT UNSIGNED PRIMARY KEY,
  name VARCHAR(50) UNIQUE
);

CREATE TABLE videogames.game_category (
  game_id MEDIUMINT UNSIGNED ,
  category_id TINYINT UNSIGNED ,
  PRIMARY KEY (game_id, category_id),
  FOREIGN KEY (game_id) REFERENCES videogames.game(id),
  FOREIGN KEY (category_id) REFERENCES videogames.category(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO videogames.category (id, name) VALUES
  (1, 'Action'),
  (2, 'Aventure'),
  (3, 'Sport'),
  (4, 'Open World');

INSERT INTO videogames.game_category (game_id, category_id) VALUES
  (1, 1),
  (1, 2),
  (2, 2),
  (2, 1),
  (3, 1),
  (3, 4);
