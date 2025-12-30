<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'crud_app');
define('DB_USER', 'root');
define('DB_PASS', '');

// Create database connection
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Start session
session_start();

// Helper function to set flash message
function setMessage($message, $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

// Helper function to get and clear flash message
function getMessage() {
    if (isset($_SESSION['message'])) {
        $message = [
            'text' => $_SESSION['message'],
            'type' => $_SESSION['message_type']
        ];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        return $message;
    }
    return null;
}
?>