CREATE DATABASE `planner`;
USE `planner`;

-- Users Table
CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `admin` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
);

-- Priority Table
CREATE TABLE `priority` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Status Table
CREATE TABLE `status` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Categories Table
CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- Tasks Table
CREATE TABLE `tasks` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `end_datetime` DATETIME,
  `priority` int(11) UNSIGNED,
  `status` int(11) UNSIGNED,
  `category` int(11) UNSIGNED,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`priority`) REFERENCES `priority` (`id`),
  FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
);

-- Insert Priority Data
REPLACE INTO `priority` (`title`) VALUES
  ('Low'),
  ('Medium'),
  ('High');

-- Insert Status Data
REPLACE INTO `status` (`title`) VALUES
  ('To Do'),
  ('Doing'),
  ('Done');

-- Events Table
CREATE TABLE `events` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `category` int(11) UNSIGNED,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `date` DATE NOT NULL,
  `start_time` TIME,
  `end_time` TIME,
  `location` VARCHAR(500),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
);

-- Reminders Table
CREATE TABLE `reminders` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `task_id` int(11) UNSIGNED DEFAULT NULL,
  `event_id` int(11) UNSIGNED DEFAULT NULL,
  `time` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  FOREIGN KEY (`event_id`) REFERENCES `events` (`id`)
);
