<?php
require_once 'config.php';

$pageTitle = 'Edit Task';

// Get task ID
$id = $_GET['id'] ?? 0;

if (!$id) {
    setMessage('Invalid task ID', 'error');
    header('Location: list.php');
    exit;
}

$pdo = getDBConnection();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'pending';
    
    // Validation
    $errors = [];
    
    if (empty($title)) {
        $errors[] = 'Title is required';
    } elseif (strlen($title) > 255) {
        $errors[] = 'Title must be less than 255 characters';
    }
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ?");
            $stmt->execute([$title, $description, $status, $id]);
            
            setMessage('Task updated successfully!', 'success');
            header('Location: view.php?id=' . $id);
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch task
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    setMessage('Task not found', 'error');
    header('Location: list.php');
    exit;
}

// Use POST data if available, otherwise use database values
$title = $_POST['title'] ?? $task['title'];
$description = $_POST['description'] ?? $task['description'];
$status = $_POST['status'] ?? $task['status'];

require_once 'header.php';
?>

<div class="page-header">
    <h1>Edit Task</h1>
    <p>Update task information</p>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-error">
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="form-container">
    <form method="POST" action="edit.php?id=<?php echo $id; ?>" class="task-form">
        <div class="form-group">
            <label for="title">Task Title *</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                placeholder="Enter task title"
                value="<?php echo htmlspecialchars($title); ?>"
                required
            >
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea 
                id="description" 
                name="description" 
                rows="5"
                placeholder="Enter task description"
            ><?php echo htmlspecialchars($description); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>
                    Pending
                </option>
                <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>
                    Completed
                </option>
            </select>
        </div>
        
        <div class="form-info">
            <small>Task ID: #<?php echo $task['id']; ?></small>
            <small>Created: <?php echo date('M d, Y', strtotime($task['created_at'])); ?></small>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-success">Update Task</button>
            <a href="view.php?id=<?php echo $id; ?>" class="btn btn-secondary">Cancel</a>
            <button type="button" onclick="confirmDelete(<?php echo $id; ?>)" class="btn btn-danger">Delete</button>
        </div>
    </form>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
        window.location.href = `delete.php?id=${id}`;
    }
}
</script>

<?php require_once 'footer.php'; ?>