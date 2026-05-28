-- create_afroevents_simple.sql

-- 1) Create database
CREATE DATABASE IF NOT EXISTS afroevents_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE afroevents_db;

-- 2) Users table (simple login)
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(255) DEFAULT NULL,
  phone VARCHAR(50) DEFAULT NULL,
  role ENUM('user','organizer','admin') NOT NULL DEFAULT 'user',
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_email (email),
  INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3) Events table (uses single DATETIME for start)
CREATE TABLE IF NOT EXISTS events (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL COMMENT 'creator user id',
  title VARCHAR(255) NOT NULL,
  category VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  tags VARCHAR(255) DEFAULT NULL,
  start_at DATETIME NOT NULL,
  location VARCHAR(255) NOT NULL,
  full_address VARCHAR(512) DEFAULT NULL,
  event_type VARCHAR(50) DEFAULT 'in-person',
  duration VARCHAR(50) DEFAULT NULL,
  ticket_type VARCHAR(50) DEFAULT 'free',
  ticket_price DECIMAL(10,2) DEFAULT NULL,
  ticket_quantity INT DEFAULT NULL,
  tickets_sold INT DEFAULT 0,
  early_bird_enabled TINYINT(1) DEFAULT 0,
  early_bird_price DECIMAL(10,2) DEFAULT NULL,
  early_bird_deadline DATE DEFAULT NULL,
  organizer_name VARCHAR(255) DEFAULT NULL,
  organizer_email VARCHAR(255) DEFAULT NULL,
  organizer_phone VARCHAR(50) DEFAULT NULL,
  website VARCHAR(255) DEFAULT NULL,
  facebook_url VARCHAR(255) DEFAULT NULL,
  instagram_url VARCHAR(255) DEFAULT NULL,
  twitter_url VARCHAR(255) DEFAULT NULL,
  event_image VARCHAR(512) DEFAULT NULL,
  status VARCHAR(50) DEFAULT 'pending',
  featured TINYINT(1) DEFAULT 0,
  views_count INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_start_at (start_at),
  INDEX idx_category (category),
  INDEX idx_status (status),
  INDEX idx_user_id (user_id),
  INDEX idx_featured (featured),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4) Bookings table
CREATE TABLE IF NOT EXISTS bookings (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  booking_reference VARCHAR(100) NOT NULL UNIQUE,
  user_id INT UNSIGNED NOT NULL,
  event_id INT UNSIGNED NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  payment_status ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  booking_status ENUM('pending','confirmed','cancelled','checked_in') NOT NULL DEFAULT 'pending',
  payment_id VARCHAR(255) DEFAULT NULL,
  checked_in TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_booking_reference (booking_reference),
  INDEX idx_user_id (user_id),
  INDEX idx_event_id (event_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5) Favorites
CREATE TABLE IF NOT EXISTS favorites (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  event_id INT UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE INDEX idx_user_event (user_id, event_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 6) Reviews
CREATE TABLE IF NOT EXISTS reviews (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  event_id INT UNSIGNED NOT NULL,
  rating TINYINT NOT NULL,
  comment TEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_event_id (event_id),
  INDEX idx_user_id (user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- End of schema
