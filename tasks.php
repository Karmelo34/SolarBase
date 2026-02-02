<?php
session_start();
// Simple authentication check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Tasks & Scheduling';

// Include mock data
include_once 'data/mock_data.php';

// Handle task status filter
$status_filter = $_GET['status'] ?? 'all';
$filtered_tasks = $tasks;

if ($status_filter !== 'all') {
    $filtered_tasks = array_filter($tasks, function($task) use ($status_filter) {
        return strtolower($task['status']) === $status_filter;
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarPro - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/tasks.css">
</head>
<body>
    <div class="app-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="tasks-container">
                <div class="tasks-header">
                    <div>
                        <h1>Tasks & Scheduling</h1>
                        <p class="text-muted">Manage and assign tasks to your technicians</p>
                    </div>
                    <div class="tasks-actions">
                        <div class="search-container">
                            <span class="search-icon">🔍</span>
                            <input type="search" placeholder="Search tasks..." class="search-input">
                        </div>
                        <div class="filter-container">
                            <select class="filter-select" onchange="window.location.href='tasks.php?status='+this.value">
                                <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Tasks</option>
                                <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="in progress" <?php echo $status_filter === 'in progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </div>
                        <a href="tasks.php?action=new" class="btn btn-primary">
                            <span class="icon">+</span> New Task
                        </a>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th class="hide-mobile">Project</th>
                                <th class="hide-tablet">Assignee</th>
                                <th class="hide-mobile">Status</th>
                                <th class="hide-mobile">Priority</th>
                                <th class="hide-desktop">Date & Location</th>
                                <th class="actions-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filtered_tasks as $task): ?>
                                <tr>
                                    <td class="task-name"><?php echo $task['title']; ?></td>
                                    <td class="hide-mobile"><?php echo $task['project']; ?></td>
                                    <td class="hide-tablet">
                                        <div class="assignee-info">
                                            <div class="avatar small">
                                                <?php echo $task['assignee']['initials']; ?>
                                            </div>
                                            <span><?php echo $task['assignee']['name']; ?></span>
                                        </div>
                                    </td>
                                    <td class="hide-mobile">
                                        <span class="badge <?php echo strtolower(str_replace(' ', '-', $task['status'])); ?>">
                                            <?php echo $task['status']; ?>
                                        </span>
                                    </td>
                                    <td class="hide-mobile">
                                        <span class="badge <?php echo strtolower($task['priority']); ?>">
                                            <?php echo $task['priority']; ?>
                                        </span>
                                    </td>
                                    <td class="hide-desktop">
                                        <div class="task-details-compact">
                                            <div class="task-detail">
                                                <span class="icon">📅</span>
                                                <span><?php echo $task['date']; ?></span>
                                            </div>
                                            <div class="task-detail">
                                                <span class="icon">📍</span>
                                                <span class="truncate"><?php echo $task['location']; ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-icon dropdown-toggle">⋮</button>
                                            <div class="dropdown-menu">
                                                <a href="tasks.php?action=edit&id=<?php echo $task['id']; ?>" class="dropdown-item">
                                                    <span class="icon">✏️</span> Edit Task
                                                </a>
                                                <a href="tasks.php?action=reschedule&id=<?php echo $task['id']; ?>" class="dropdown-item">
                                                    <span class="icon">📅</span> Reschedule
                                                </a>
                                                <a href="#" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this task?')">
                                                    <span class="icon">🗑️</span> Delete Task
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Simple dropdown toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown-toggle');
            
            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var menu = this.nextElementSibling;
                    
                    // Close all other dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                        if (menu !== e.target.nextElementSibling) {
                            menu.classList.remove('show');
                        }
                    });
                    
                    // Toggle current dropdown
                    menu.classList.toggle('show');
                });
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    menu.classList.remove('show');
                });
            });
        });
    </script>
</body>
</html>
