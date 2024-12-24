-- Drop Database if it already exists (Optional Cleanup)
DROP DATABASE IF EXISTS yourDB;

-- Create Database and User
CREATE DATABASE IF NOT EXISTS yourDB;
CREATE USER IF NOT EXISTS 'user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON yourDB.* TO 'user'@'localhost';
FLUSH PRIVILEGES;

-- Use the Created Database
USE yourDB;

-- Create Table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    balance DECIMAL(15,2) DEFAULT 0.00
);

-- Create Table topup
CREATE TABLE IF NOT EXISTS topup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    amount INT,
    created_at DATETIME DEFAULT current_timestamp(),
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create Table transfer
CREATE TABLE IF NOT EXISTS transfer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    amount INT,
    created_at DATETIME DEFAULT current_timestamp(),
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

-- Create Table chat
CREATE TABLE IF NOT EXISTS chat (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    receiver_id INT(11) NOT NULL,
    message TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id), 
    FOREIGN KEY (receiver_id) REFERENCES users(id) 
);