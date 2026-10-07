CREATE DATABASE IF NOT EXISTS movie_booking;
USE movie_booking;

CREATE TABLE admin (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) UNIQUE, password VARCHAR(255));
CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), email VARCHAR(100) UNIQUE, password VARCHAR(255));
CREATE TABLE movies (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(150), genre VARCHAR(50), language VARCHAR(50), duration INT, description TEXT, poster VARCHAR(255));
CREATE TABLE theatres (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), location VARCHAR(100), city VARCHAR(100), screens INT);
CREATE TABLE screens (
  id INT AUTO_INCREMENT PRIMARY KEY, theatre_id INT, screen_name VARCHAR(50), total_seats INT,
  FOREIGN KEY (theatre_id) REFERENCES theatres(id) ON DELETE CASCADE
);
CREATE TABLE shows (
  id INT AUTO_INCREMENT PRIMARY KEY, movie_id INT, screen_id INT, show_date DATE, show_time TIME,
  price DECIMAL(8,2), status VARCHAR(20) DEFAULT 'Available',
  FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
  FOREIGN KEY (screen_id) REFERENCES screens(id) ON DELETE CASCADE
);
CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, show_id INT,
  seats VARCHAR(255), seat_count INT, total_price DECIMAL(10,2),
  status VARCHAR(20) DEFAULT 'Pending', booked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE
);

-- Default admin login: admin / admin123
INSERT INTO admin (username, password) VALUES ('admin', '$2y$12$BRAX/W2B.BTrHBywPbcfQuA9yOiGqWWb4Sj2E7.vjkvK/xd2bg4Ay');
