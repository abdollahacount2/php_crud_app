<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Task Manager'; ?> - CRUD App</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <h1>📝 Task Manager</h1>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="create.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'create.php' ? 'active' : ''; ?>">Add Task</a></li>
                <li><a href="list.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'list.php' ? 'active' : ''; ?>">All Tasks</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <?php
        $message = getMessage();
        if ($message):
        ?>
        <div class="alert alert-<?php echo $message['type']; ?>" id="alertMessage">
            <?php echo htmlspecialchars($message['text']); ?>
        </div>
        <?php endif; ?>