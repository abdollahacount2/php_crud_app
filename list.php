<?php
require_once 'config.php';

$pageTitle = 'All Tasks';

// Get filter and sort parameters
$status = $_GET['status'] ?? 'all';
$sort = $_GET['sort'] ?? 'created_at';
$order = $_GET['order'] ?? 'DESC';

// Build query
$pdo = getDBConnection();
$query = "SELECT * FROM tasks";

if ($status !== 'all') {
    $query .= " WHERE status = :status";
}

$allowedSort = ['title', 'status', 'created_at'];
$allowedOrder = ['ASC', 'DESC'];

if (in_array($sort, $allowedSort) && in_array($order, $allowedOrder)) {
    $query .= " ORDER BY $sort $order";
}

$stmt = $pdo->prepare($query);

if ($status !== 'all') {
    $stmt->bindParam(':status', $status);
}

$stmt->execute();
$tasks = $stmt->fetchAll();

require_once 'header.php';
?>

<div class="page-header">
    <h1>All Tasks</h1>
    <p>Manage and organize your tasks</p>
</div>

<div class="filter-bar">
    <div class="filter-group">
        <label>Filter by Status:</label>
        <select id="statusFilter" onchange="filterTasks()">
            <option value="all" <?php echo $status === 'all' ? 'selected' : ''; ?>>All</option>
            <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Completed</option>
        </select>
    </div>
    
    <div class="filter-group">
        <label>Sort by:</label>
        <select id="sortBy" onchange="filterTasks()">
            <option value="created_at" <?php echo $sort === 'created_at' ? 'selected' : ''; ?>>Date Created</option>
            <option value="title" <?php echo $sort === 'title' ? 'selected' : ''; ?>>Title</option>
            <option value="status" <?php echo $sort === 'status' ? 'selected' : ''; ?>>Status</option>
        </select>
    </div>
    
    <div class="filter-group">
        <label>Order:</label>
        <select id="orderBy" onchange="filterTasks()">
            <option value="DESC" <?php echo $order === 'DESC' ? 'selected' : ''; ?>>Descending</option>
            <option value="ASC" <?php echo $order === 'ASC' ? 'selected' : ''; ?>>Ascending</option>
        </select>
    </div>
</div>

<?php if (count($tasks) === 0): ?>
<div class="empty-state">
    <div class="empty-icon">📭</div>
    <h2>No tasks found</h2>
    <p>Start by creating your first task</p>
    <a href="create.php" class="btn btn-primary">Add New Task</a>
</div>
<?php else: ?>
<div class="task-grid">
    <?php foreach ($tasks as $task): ?>
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
        
        <div class="task-actions">
            <a href="view.php?id=<?php echo $task['id']; ?>" class="btn btn-info btn-sm">View</a>
            <a href="edit.php?id=<?php echo $task['id']; ?>" class="btn btn-success btn-sm">Edit</a>
            <button onclick="confirmDelete(<?php echo $task['id']; ?>)" class="btn btn-danger btn-sm">Delete</button>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="pagination">
    <p>Showing <?php echo count($tasks); ?> task(s)</p>
</div>
<?php endif; ?>

<script>
function filterTasks() {
    const status = document.getElementById('statusFilter').value;
    const sort = document.getElementById('sortBy').value;
    const order = document.getElementById('orderBy').value;
    
    window.location.href = `list.php?status=${status}&sort=${sort}&order=${order}`;
}

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this task?')) {
        window.location.href = `delete.php?id=${id}`;
    }
}
</script>

<?php require_once 'footer.php'; ?>