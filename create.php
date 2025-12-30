<?php
require_once 'config.php';

$pageTitle = 'Add New Task';

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
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("INSERT INTO tasks (title, description, status) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $status]);
            
            setMessage('Task created successfully!', 'success');
            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

require_once 'header.php';
?>

<div class="page-header">
    <h1>Add New Task</h1>
    <p>Create a new task to keep track of your work</p>
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
    <form method="POST" action="create.php" class="task-form">
        <div class="form-group">
            <label for="title">Task Title *</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                placeholder="Enter task title"
                value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"
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
            ><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="pending" <?php echo ($_POST['status'] ?? '') === 'pending' ? 'selected' : ''; ?>>
                    Pending
                </option>
                <option value="completed" <?php echo ($_POST['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>
                    Completed
                </option>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Task</button>
            <a href="list.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>