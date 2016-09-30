CREATE DATABASE friendzonia;
USE friendzonia;

CREATE TABLE users(
id int AUTO_INCREMENT,
fname VARCHAR (255) NOT NULL,
lname VARCHAR(255) NOT NULL,
email VARCHAR(255) UNIQUE NOT NULL,
password_1 VARCHAR(255) NOT NULL,
phone VARCHAR(255),
gender VARCHAR(255) NOT NULL,
image TEXT,
birthdate date NOT NULL,
hometown VARCHAR(255),
martial_status VARCHAR(255),
about_me TEXT,
PRIMARY KEY(id)
);

CREATE TABLE posts(
id int AUTO_INCREMENT,
user_id int NOT NULL,
caption TEXT,
postimage TEXT ,
posted_time date NOT NULL,
poster_name VARCHAR(255) NOT NULL,
isPublic VARCHAR(255) NOT NULL,
PRIMARY KEY(id,user_id)
);


CREATE TABLE IF NOT EXISTS `friend_requests` (
	`id` int AUTO_INCREMENT,
  `user_from` int(200) NOT NULL,
  `user_to` int(200) NOT NULL,
  `state` int(1) NOT NULL,
  PRIMARY KEY (`id`)
);



CREATE TABLE IF NOT EXISTS `friends` (
	`user_id` int(200) ,
  `friend_id` int(200) ,
  PRIMARY KEY (`user_id`,`friend_id`)
);

ALTER TABLE posts ADD FOREIGN KEY(user_id)
REFERENCES users(id);

ALTER TABLE friend_requests ADD FOREIGN KEY(user_from)
REFERENCES users(id);

ALTER TABLE friend_requests ADD FOREIGN KEY(user_to)
REFERENCES users(id);

ALTER TABLE friends ADD FOREIGN KEY(user_id)
REFERENCES users(id);

ALTER TABLE friends ADD FOREIGN KEY(friend_id)
REFERENCES users(id);




/*ALTER TABLE usr ADD FOREIGN KEY(department_id)
REFERENCES Department(dep_id);

ALTER TABLE course ADD FOREIGN KEY(department_id)
REFERENCES Department(dep_id);
*/

