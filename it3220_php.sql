CREATE DATABASE IF NOT EXISTS it3220_php
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE it3220_php;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    dob DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (code, full_name, email, dob) VALUES
('SV001', 'Nguyễn Văn A', 'a@gmail.com', '2002-01-01'),
('SV002', 'Trần Thị B', 'b@gmail.com', '2001-05-10'),
('SV003', 'Lê Văn C', 'c@gmail.com', '2003-03-15'),
('SV004', 'Phạm Thị D', 'd@gmail.com', NULL),
('SV005', 'Hoàng Văn E', 'e@gmail.com', '2002-12-20');
