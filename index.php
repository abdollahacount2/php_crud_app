<?php
require_once 'config.php';

$pageTitle = 'Home';

// Get statistics
$pdo = getDBConnection();

$totalStmt = $pdo->query("SELECT COUNT(*) as total FROM tasks");
$total = $totalStmt->fetch()['total'];

$pendingStmt = $pdo->query("SELECT COUNT(*) as pending FROM tasks WHERE status = 'pending'");
$pending = $pendingStmt->fetch()['pending'];

$completedStmt = $pdo->query("SELECT COUNT(*) as completed FROM tasks WHERE status = 'completed'");
$completed = $completedStmt->fetch()['completed'];

// Get recent tasks
$recentStmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC LIMIT 5");
$recentTasks = $recentStmt->fetchAll();

require_once 'header.php';
?>

<div class="hero">
    <h1>Welcome to Task Manager</h1>
    <p>Organize your tasks efficiently with our simple CRUD application</p>
    <div class="hero-buttons">
        <a href="create.php" class="btn btn-primary">Add New Task</a>
        <a href="list.php" class="btn btn-secondary">View All Tasks</a>
    </div>
</div>

<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon">📊</div>
        <div class="stat-number"><?php echo $total; ?></div>
        <div class="stat-label">Total Tasks</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-number"><?php echo $pending; ?></div>
        <div class="stat-label">Pending</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-number"><?php echo $completed; ?></div>
        <div class="stat-label">Completed</div>
    </div>
</div>

<?php if (count($recentTasks) > 0): ?>
<div class="section">
    <h2>Recent Tasks</h2>
    <div class="task-list">
        <?php foreach ($recentTasks as $task): ?>
        <div class="task-card">
            <div class="task-header">
                <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                <span class="badge badge-<?php echo $task['status']; ?>">
                    <?php echo ucfirst($task['status']); ?>
                </span>
            </div>
            <p class="task-description">
                <?php echo htmlspecialchars($task['description'] ?: 'No description'); ?>
            </p>
            <div class="task-meta">
                <small>Created: <?php echo date('M d, Y', strtotime($task['created_at'])); ?></small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php require_once 'footer.php'; ?>