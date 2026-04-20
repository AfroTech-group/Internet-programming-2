-- Migration: add avatar column to users table
ALTER TABLE users
ADD COLUMN avatar VARCHAR(512) DEFAULT NULL;

-- Run this in your MySQL (phpMyAdmin or mysql CLI). Example:
-- C:\xampp\mysql\bin\mysql.exe -u root -p afroevents_db < migrations/add_avatar_column.sql
