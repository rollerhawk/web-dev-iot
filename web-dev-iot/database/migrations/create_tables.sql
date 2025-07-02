-- sensor-dashboard/database/migrations/create_tables.sql

CREATE DATABASE IF NOT EXISTS sensor_app
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sensor_app;

CREATE TABLE IF NOT EXISTS sensors (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  type VARCHAR(100) NOT NULL,
  unit VARCHAR(20) NOT NULL DEFAULT '';
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS sensordata (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  sensor_id   INT NOT NULL,
  measurement DOUBLE NOT NULL,
  timestamp   DATETIME NOT NULL,
  FOREIGN KEY (sensor_id) REFERENCES sensors(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

