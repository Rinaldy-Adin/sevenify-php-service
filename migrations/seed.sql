-- Create the database if it doesn't exist (if applicable)
CREATE DATABASE IF NOT EXISTS sevenify;

-- Use the database
USE sevenify;

-- Create tables
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) UNIQUE NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL
);

CREATE TABLE IF NOT EXISTS albums (
    album_id INT AUTO_INCREMENT PRIMARY KEY,
    album_name VARCHAR(255) NOT NULL,
    album_owner INT NOT NULL,
    album_cover_path VARCHAR(255),
    FOREIGN KEY (album_owner) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS playlists (
    playlist_id INT AUTO_INCREMENT PRIMARY KEY,
    playlist_name VARCHAR(255) NOT NULL,
    playlist_owner INT NOT NULL,
    playlist_cover_path VARCHAR(255),
    FOREIGN KEY (playlist_owner) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS music (
    music_id INT AUTO_INCREMENT PRIMARY KEY,
    music_name VARCHAR(255) NOT NULL,
    music_owner INT NOT NULL,
    music_genre VARCHAR(255),
    music_upload_date DATE NOT NULL,
    FOREIGN KEY (music_owner) REFERENCES users(user_id),
);

CREATE TABLE IF NOT EXISTS playlist_music (
    music_id INT NOT NULL,
    playlist_id INT NOT NULL,
    PRIMARY KEY (music_id, playlist_id),
    FOREIGN KEY (music_id) REFERENCES music(music_id),
    FOREIGN KEY (playlist_id) REFERENCES playlists(playlist_id)
);

CREATE TABLE IF NOT EXISTS album_music (
    music_id INT NOT NULL,
    album_id INT NOT NULL,
    PRIMARY KEY (music_id, album_id),
    FOREIGN KEY (music_id) REFERENCES music(music_id),
    FOREIGN KEY (album_id) REFERENCES albums(album_id)
);