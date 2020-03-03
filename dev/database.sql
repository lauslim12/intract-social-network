DROP DATABASE IF EXISTS intract;
CREATE DATABASE IF NOT EXISTS intract;
USE intract;

CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(25),
  last_name VARCHAR(25),
  username VARCHAR(100),
  email VARCHAR(100),
  password VARCHAR(255),
  birthday DATE,
  gender VARCHAR(2),
  signup_date DATE,
  profile_pic VARCHAR(255),
  num_posts INT,
  num_likes INT,
  user_closed VARCHAR(3),
  friend_array TEXT,
  PRIMARY KEY (id, username, email)
);

CREATE TABLE IF NOT EXISTS posts (
  id INT NOT NULL AUTO_INCREMENT,
  body TEXT,
  added_by VARCHAR(60),
  user_to VARCHAR(60),
  date_added DATETIME,
  user_closed VARCHAR(3),
  deleted VARCHAR(3),
  likes INT,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS post_comments (
  id INT NOT NULL AUTO_INCREMENT,
  post_body TEXT,
  posted_by VARCHAR(60),
  posted_to VARCHAR(60),
  date_added DATETIME,
  removed VARCHAR(3),
  post_id INT,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS likes (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(60),
  post_id INT,
  PRIMARY KEY (id)
);