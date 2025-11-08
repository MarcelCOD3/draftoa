CREATE DATABASE IF NOT EXISTS draftosaurus_db;
USE draftosaurus_db;

CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
	nickname VARCHAR(50) NOT NULL UNIQUE, 
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash CHAR(60) NOT NULL,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    is_admin BOOLEAN NOT NULL,
    banned_until DATETIME NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Games (
    game_id INT AUTO_INCREMENT PRIMARY KEY,
    date_played DATE NOT NULL,
    winner_id INT NULL,
    FOREIGN KEY (winner_id) REFERENCES Users(user_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS GamePlayers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT NOT NULL,
    user_id INT NOT NULL,
    score INT NOT NULL DEFAULT 0,
    FOREIGN KEY (game_id) REFERENCES Games(game_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Rounds (
    round_id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT NOT NULL,
    round_number TINYINT NOT NULL,
    status ENUM('in_progress', 'finished') DEFAULT 'in_progress',
    FOREIGN KEY (game_id) REFERENCES Games(game_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Turns (
    turn_id INT AUTO_INCREMENT PRIMARY KEY,
    round_id INT NOT NULL,
    turn_number INT,
    dice_face INT,
    token_placed INT,
    FOREIGN KEY (round_id) REFERENCES Rounds(round_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Rules (
    rule_id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(200) NOT NULL,
    condition_text VARCHAR(200) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Zones (
    zone_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    context VARCHAR(50) NOT NULL,
    board_type VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Dinosaurs (
    dino_id INT AUTO_INCREMENT PRIMARY KEY,
    species VARCHAR(50) NOT NULL,
    weight INT NOT NULL,
    sprite_frame1 VARCHAR(100) NOT NULL,
    sprite_frame2 VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS RecoveryPass (
    recovery_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL DEFAULT (NOW() + INTERVAL 1 HOUR),
    used BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ContactMessages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB;
