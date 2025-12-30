<?php
require_once 'config.php';

$pageTitle = 'View Task';

// Get task ID
$id = $_GET['id'] ?? 0;

if (!$id) {
    setMessage('Invalid task ID', 'error');
    header('Location: list.php');
    exit;
}

// Fetch task
$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    setMessage('Task not found', 'error');
    header('Location: list.php');
    exit;
}

require_once 'header.php';
?>

<div class="page-header">
    <h1>Task Details</h1>
    <div class="header-actions">
        <a href="list.php" class="btn btn-secondary">Back to List</a>
        <a href="edit.php?id=<?php echo $task['id']; ?>" class="btn btn-success">Edit Task</a>
    </div>
</div>

<div class="task-detail-card">
    <div class="detail-header">
        <h2><?php echo htmlspecialchars($task['title']); ?></h2>
        <span class="badge badge-<?php echo $task['status']; ?> badge-large">
            <?php echo ucfirst($task['status']); ?>
        </span>
    </div>
    
    <div class="detail-section">
        <h3>Description</h3>
        <p><?php echo nl2br(htmlspecialchars($task['description'] ?: 'No description provided')); ?></p>
    </div>
    
    <div class="detail-info">
        <div class="info-item">
            <span class="info-label">Created:</span>
            <span class="info-value"><?php echo date('F d, Y \a\t g:i A', strtotime($task['created_at'])); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Last Updated:</span>
            <span class="info-value"><?php echo date('F d, Y \a\t g:i A', strtotime($task['updated_at'])); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Task ID:</span>
            <span class="info-value">#<?php echo $task['id']; ?></span>
        </div>
    </div>
    
    <div class="detail-actions">
        <a href="edit.php?id=<?php echo $task['id']; ?>" class="btn btn-success">Edit Task</a>
        <button onclick="confirmDelete(<?php echo $task['id']; ?>)" class="btn btn-danger">Delete Task</button>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
        window.location.href = `delete.php?id=${id}`;
    }
}
</script>

<?php require_once 'footer.php'; ?>