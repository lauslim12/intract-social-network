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