CREATE TABLE `comments`(
`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
`content` VARCHAR(255),
`id_users` INT NOT NULL,
FOREIGN KEY (`id_users`) REFERENCES `users`(id)
);

--NOUVELLE TABLE
DROP TABLE users;
DROP TABLE users_comments;
DROP TABLE users_games;
DROP TABLE comments;
DROP TABLE games;

create table users(
  id int(9) primary key not null AUTO_INCREMENT,
  email varchar(255) not null,
  password varchar(255) not null,
  promo_id int(9) not null,
  foreign key(promo_id) references promos(id)
);
INSERT INTO comments (email, password, promo_id) VALUES ( 'victor1', 'root', 1);
INSERT INTO comments (email, password, promo_id) VALUES ( 'victor2', 'root', 2);
INSERT INTO comments (email, password, promo_id) VALUES ( 'victor3', 'root', 3);
INSERT INTO comments (email, password, promo_id) VALUES ( 'victor4', 'root', 4);

ALTER TABLE users DROP COLUMN promo_id;
ALTER TABLE users ADD promo_id int(9) not null;
ALTER TABLE users ADD FOREIGN KEY(`promo_id`) references `promos`(`id`);
-- Pour que ca marche il faut des données dans la table (pour tous les champs ?)

-- ALTER TABLE submittedForecast
--   ADD CONSTRAINT FOREIGN KEY (data) REFERENCES blobs (id);


create table comments(
  id int(9) primary key not null AUTO_INCREMENT,
  content varchar(255) not null,
  user_id int(9) not null, 
  foreign key(user_id) references users(id)
);
INSERT INTO comments (content, user_id) VALUES ( 'This is a comment', 2 );
INSERT INTO comments (content, user_id) VALUES ( 'This is another comment', 2 );
INSERT INTO comments (content, user_id) VALUES ( 'This is a last comment', 2 );


create table comments(
  id int(9) primary key not null AUTO_INCREMENT,
  content varchar(255) not null,
  user_id int(9) not null, 
  foreign key(user_id) references users(id)
);
INSERT INTO comments (content, user_id) VALUES ( 'This is a comment', 2 );
INSERT INTO comments (content, user_id) VALUES ( 'This is another comment', 2 );
INSERT INTO comments (content, user_id) VALUES ( 'This is a last comment', 2 );

create table users_comments(
  id int(9) primary key not null AUTO_INCREMENT,
  user_id int(9) not null,
  comment_id int(9) not null, 
  foreign key(user_id) references users(id),
  foreign key(comment_id) references comments(id)
);
INSERT INTO users_comments (user_id, comment_id) VALUES (2, 1);
INSERT INTO users_comments (user_id, comment_id) VALUES (2, 2);
INSERT INTO users_comments (user_id, comment_id) VALUES (2, 3);

create table games(
  id int(9) primary key not null AUTO_INCREMENT,
  content varchar(255) not null,
  user_id int(9) not null, 
  foreign key(user_id) references users(id)
);
INSERT INTO games (content, user_id) VALUES ( 'Mario Kart 8', 2 );
INSERT INTO games (content, user_id) VALUES ( 'Wind Waker HD', 2 );
INSERT INTO games (content, user_id) VALUES ( 'Luigi Mansion', 2 );
INSERT INTO games (content, user_id) VALUES ( 'Pong', 3 );
INSERT INTO games (content, user_id) VALUES ( 'Space Invaders', 3 );
INSERT INTO games (content, user_id) VALUES ( 'Monkey Island', 3 );
create table users_games(
  id int(9) primary key not null AUTO_INCREMENT,
  user_id int(9) not null,
  game_id int(9) not null, 
  foreign key(user_id) references users(id),
  foreign key(game_id) references games(id)
);
INSERT INTO users_games (user_id, game_id) VALUES (2, 1);
INSERT INTO users_games (user_id, game_id) VALUES (2, 2);
INSERT INTO users_games (user_id, game_id) VALUES (2, 3);
INSERT INTO users_games (user_id, game_id) VALUES (3, 4);
INSERT INTO users_games (user_id, game_id) VALUES (3, 5);
INSERT INTO users_games (user_id, game_id) VALUES (3, 6);

create table promos(
  id int(9) primary key not null AUTO_INCREMENT,
  content varchar(255) not null
  );
INSERT INTO promos (content) VALUES ( '-50%');
INSERT INTO promos (content) VALUES ( '-25%');
INSERT INTO promos (content) VALUES ( '-75%');
INSERT INTO promos (content) VALUES ( '-100%');
--END NEW-----------------------------------------------------------------


-- EXEMPLE
create table follow(
    id_abo int(9) not null AUTO_INCREMENT,
    dateAbo date not null,
    id_subscriber int(9) not null,
    id_subscribed int(9) not null,
    foreign key(id_subscriber) references user(id_user),
    foreign key(id_subscribed) references user(id_user),
    primary key(id_abo)
);

-- CREATE TABLE [IF NOT EXISTS] table_name(
--    column_1_definition,
--    column_2_definition,
--    ...,
--    table_constraints
-- ) ENGINE=storage_engine;