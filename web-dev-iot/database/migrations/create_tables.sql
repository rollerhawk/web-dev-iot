-- sensor-dashboard/database/migrations/create_tables.sql

CREATE DATABASE IF NOT EXISTS sensor_app
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sensor_app;

CREATE TABLE IF NOT EXISTS sensors (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  type VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS sensordata (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  sensor_id   INT NOT NULL,
  temperature DOUBLE NOT NULL,
  humidity    DOUBLE NOT NULL,
  timestamp   DATETIME NOT NULL,
  FOREIGN KEY (sensor_id) REFERENCES sensors(id) ON DELETE CASCADE
) ENGINE=InnoDB;
