-- ============================================================================
-- CyberSafe — Relational Database Schema & Pre-seeded Curriculum Content
-- Database Name: cybersafe_db
-- Character Set: utf8mb4 (Full Unicode Support)
-- Storage Engine: InnoDB (ACID Compliance & Foreign Key Constraints)
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `cybersafe_db` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `cybersafe_db`;

-- ----------------------------------------------------------------------------
-- 1. Table: users
-- Stores registered students, administrators, and auto-generated guest profiles
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('student', 'admin') DEFAULT 'student',
    `is_guest` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------------------------
-- 2. Table: topics
-- Master curriculum catalog of cybersecurity educational modules
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `topics` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `title` VARCHAR(120) NOT NULL,
    `category` VARCHAR(60) NOT NULL,
    `summary` TEXT NOT NULL,
    `estimated_minutes` INT DEFAULT 5,
    `order_num` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------------------------
-- 3. Table: learning_progress
-- Tracks module completions per student with unique constraint per user/topic
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `learning_progress` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `topic_slug` VARCHAR(50) NOT NULL,
    `completed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `user_topic_unique` (`user_id`, `topic_slug`),
    CONSTRAINT `fk_progress_user` FOREIGN KEY (`user_id`) 
        REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------------------------
-- 4. Table: quiz_attempts
-- Historical record of all assessment submissions and scores
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `quiz_attempts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `score` INT NOT NULL,
    `total_questions` INT NOT NULL,
    `percentage` DECIMAL(5,2) NOT NULL,
    `completed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_quiz_user` FOREIGN KEY (`user_id`) 
        REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------------------------
-- 5. Table: simulator_attempts
-- Historical record of phishing threat evaluations in the email sandbox
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `simulator_attempts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `scenario_id` VARCHAR(50) NOT NULL,
    `user_verdict` ENUM('phishing', 'legitimate') NOT NULL,
    `is_correct` TINYINT(1) NOT NULL,
    `completed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_sim_user` FOREIGN KEY (`user_id`) 
        REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------------------------
-- 6. Table: feedback
-- Submissions from the contact and suggestion form
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `feedback` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    `message` TEXT NOT NULL,
    `status` ENUM('new', 'reviewed') DEFAULT 'new',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- Seed Initial Curriculum Data
-- ============================================================================
INSERT INTO `topics` (`slug`, `title`, `category`, `summary`, `estimated_minutes`, `order_num`)
VALUES 
    ('phishing', 'Phishing Attacks & Email Spoofing', 'Social Exploits', 'Deceptive communications masquerading as trustworthy entities to harvest confidential student credentials.', 5, 1),
    ('malware', 'Malware & Ransomware Defense', 'System Security', 'Hostile software designed to infiltrate systems, extract source code, record keystrokes, and lock project files.', 6, 2),
    ('passwords', 'Password Hygiene & Passkeys', 'Access Control', 'Understanding password entropy, defeating brute-force and credential stuffing, and adopting modern managers.', 5, 3),
    ('social-eng', 'Social Engineering & Psychological Traps', 'Human Factors', 'Techniques used by adversaries to exploit human trust, politeness, fear, and urgency to bypass digital defenses.', 6, 4),
    ('safe-browsing', 'Safe Browsing & Public Wi-Fi Risks', 'Network Defense', 'Understanding Man-in-the-Middle attacks, rogue access points, SSL certificates, and defensive hygiene.', 5, 5),
    ('mfa', 'Multi-Factor Authentication (MFA)', 'Authentication', 'Why passwords alone are insufficient, exploring factors of authentication, and authenticator apps vs SMS OTPs.', 5, 6)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);

-- Optional Demo Seed Student (Password: password123)
-- bcrypt hash for 'password123': $2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm
INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `is_guest`)
VALUES (1, 'demo_student', 'student@apex-university.edu', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'student', 0)
ON DUPLICATE KEY UPDATE `username` = VALUES(`username`);
