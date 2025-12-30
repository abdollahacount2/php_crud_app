-- Create database
CREATE DATABASE IF NOT EXISTS crud_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE crud_app;

-- Create tasks table
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO tasks (title, description, status) VALUES
('Complete project documentation', 'Write comprehensive documentation for the CRUD application including setup instructions, API documentation, and user guide.', 'pending'),
('Review code and refactor', 'Review the entire codebase for optimization opportunities, code quality improvements, and best practices implementation.', 'completed'),
('Implement user authentication', 'Add login and registration functionality with password hashing and session management for secure user access.', 'pending'),
('Design database schema', 'Create a normalized database schema with proper relationships, indexes, and constraints for optimal performance.', 'completed'),
('Test application thoroughly', 'Perform comprehensive testing including unit tests, integration tests, and user acceptance testing.', 'pending'),
('Deploy to production server', 'Set up production environment, configure web server, and deploy the application with proper security measures.', 'pending'),
('Create user manual', 'Write detailed user manual with screenshots and step-by-step instructions for all features.', 'completed'),
('Optimize database queries', 'Analyze and optimize slow database queries, add proper indexes, and implement caching where needed.', 'pending');