<?php
session_start();
// Simple authentication check
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: login.php');
    exit;
}

// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page == 'index.php') {
    $page_title = 'Dashboard';
} else {
    $page_title = ucfirst(str_replace('.php', '', $current_page));
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarPro - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="app-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <div>
                        <h1>Dashboard</h1>
                        <p class="text-muted">Welcome back! Here's an overview of your solar installation projects.</p>
                    </div>
                    <a href="projects.php?action=new" class="btn btn-primary">
                        <span class="icon">+</span> New Project
                    </a>
                </div>

                <!-- Dashboard Stats -->
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-header">
                            <h3>Active Projects</h3>
                            <span class="icon">📊</span>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">12</div>
                            <p class="stat-change">+2 from last month</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <h3>Completed Projects</h3>
                            <span class="icon">✓</span>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">48</div>
                            <p class="stat-change">+8 from last month</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <h3>Pending Tasks</h3>
                            <span class="icon">⏱️</span>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">24</div>
                            <p class="stat-change">-3 from yesterday</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <h3>Total Clients</h3>
                            <span class="icon">👥</span>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">36</div>
                            <p class="stat-change">+4 from last month</p>
                        </div>
                    </div>
                </div>

                <!-- Projects and Tasks Overview -->
                <div class="overview-container">
                    <div class="card projects-overview">
                        <div class="card-header">
                            <h2>Project Overview</h2>
                            <p class="text-muted">Your active solar installation projects</p>
                        </div>
                        <div class="card-content">
                            <?php foreach ($projects as $project): ?>
                                <?php if ($project['status'] != 'Completed'): ?>
                                <div class="project-item">
                                    <div class="project-header">
                                        <div>
                                            <h3><?php echo $project['name']; ?></h3>
                                            <p class="text-muted">Client: <?php echo $project['client']; ?></p>
                                        </div>
                                        <span class="badge <?php echo strtolower(str_replace(' ', '-', $project['status'])); ?>">
                                            <?php echo $project['status']; ?>
                                        </span>
                                    </div>
                                    <div class="progress-container">
                                        <div class="progress-info">
                                            <span>Progress</span>
                                            <span><?php echo $project['progress']; ?>%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: <?php echo $project['progress']; ?>%"></div>
                                        </div>
                                    </div>
                                    <div class="project-footer">
                                        <span class="text-muted">Due: <?php echo $project['dueDate']; ?></span>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="card tasks-overview">
                        <div class="card-header">
                            <h2>Upcoming Tasks</h2>
                            <p class="text-muted">Tasks scheduled for the next 7 days</p>
                        </div>
                        <div class="card-content">
                            <?php foreach ($tasks as $task): ?>
                                <div class="task-item">
                                    <div class="task-header">
                                        <div>
                                            <h3><?php echo $task['title']; ?></h3>
                                            <p class="text-muted"><?php echo $task['project']; ?></p>
                                        </div>
                                        <span class="badge <?php echo strtolower($task['priority']); ?>">
                                            <?php echo $task['priority']; ?>
                                        </span>
                                    </div>
                                    <div class="task-details">
                                        <div class="task-detail">
                                            <span class="icon">📅</span>
                                            <span><?php echo $task['date']; ?></span>
                                        </div>
                                        <div class="task-detail">
                                            <span class="icon">📍</span>
                                            <span><?php echo $task['location']; ?></span>
                                        </div>
                                    </div>
                                    <div class="task-footer">
                                        <div class="assignee">
                                            <div class="avatar">
                                                <?php echo substr($task['assignee']['name'], 0, 2); ?>
                                            </div>
                                            <span><?php echo $task['assignee']['name']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card activity-feed">
                    <div class="card-header">
                        <h2>Recent Activity</h2>
                        <p class="text-muted">Latest actions across all projects</p>
                    </div>
                    <div class="card-content">
                        <?php foreach ($activities as $activity): ?>
                            <div class="activity-item">
                                <div class="avatar">
                                    <?php echo substr($activity['user']['name'], 0, 2); ?>
                                </div>
                                <div class="activity-details">
                                    <p>
                                        <strong><?php echo $activity['user']['name']; ?></strong> 
                                        <?php echo $activity['action']; ?> for 
                                        <strong><?php echo $activity['project']; ?></strong>
                                    </p>
                                    <p class="text-muted"><?php echo $activity['time']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
