<?php
require_once 'config.php';

// Get task ID
$id = $_GET['id'] ?? 0;

if (!$id) {
    setMessage('Invalid task ID', 'error');
    header('Location: list.php');
    exit;
}

try {
    $pdo = getDBConnection();
    
    // Check if task exists
    $stmt = $pdo->prepare("SELECT id FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    $task = $stmt->fetch();
    
    if (!$task) {
        setMessage('Task not found', 'error');
        header('Location: list.php');
        exit;
    }
    
    // Delete the task
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    
    setMessage('Task deleted successfully!', 'success');
} catch (PDOException $e) {
    setMessage('Error deleting task: ' . $e->getMessage(), 'error');
}

header('Location: list.php');
exit;
?>