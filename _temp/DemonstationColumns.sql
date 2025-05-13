create database php_rest;
use php_rest;

-- one column for demonstration purposes
CREATE TABLE students (
	id int primary key auto_increment,
    fullname VARCHAR(255)
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255),
    password VARCHAR(255),
    created_at DATETIME
);

-- drop table users;
-- drop table students;
