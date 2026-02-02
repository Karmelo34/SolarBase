<?php
session_start();
// Simple authentication check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Projects';

// Include mock data
include_once 'data/mock_data.php';

// Handle form submission for new project (in a real app, you'd save to a database)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_project') {
    // Process form data
    $success_message = "Project created successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarPro - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/projects.css">
</head>
<body>
    <div class="app-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="projects-container">
                <?php if (isset($_GET['action']) && $_GET['action'] === 'new'): ?>
                    <!-- New Project Form -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Create New Project</h2>
                            <a href="projects.php" class="btn btn-outline">Cancel</a>
                        </div>
                        <div class="card-content">
                            <?php if (isset($success_message)): ?>
                                <div class="alert alert-success">
                                    <?php echo $success_message; ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="post" action="projects.php" class="form">
                                <input type="hidden" name="action" value="create_project">
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="project_name">Project Name</label>
                                        <input type="text" id="project_name" name="project_name" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="client">Client</label>
                                        <select id="client" name="client" required>
                                            <option value="">Select a client</option>
                                            <?php foreach ($clients as $client): ?>
                                                <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" id="start_date" name="start_date" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="due_date">Due Date</label>
                                        <input type="date" id="due_date" name="due_date" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" id="location" name="location" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" rows="4"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="manager">Project Manager</label>
                                    <select id="manager" name="manager" required>
                                        <option value="">Select a manager</option>
                                        <option value="1">Mike Thompson</option>
                                        <option value="2">Sarah Lee</option>
                                        <option value="3">John Davis</option>
                                        <option value="4">Lisa Miller</option>
                                    </select>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Create Project</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Projects List -->
                    <div class="projects-header">
                        <div>
                            <h1>Projects</h1>
                            <p class="text-muted">Manage and track all your solar installation projects</p>
                        </div>
                        <div class="projects-actions">
                            <div class="search-container">
                                <span class="search-icon">🔍</span>
                                <input type="search" placeholder="Search projects..." class="search-input">
                            </div>
                            <a href="projects.php?action=new" class="btn btn-primary">
                                <span class="icon">+</span> New Project
                            </a>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Client</th>
                                    <th class="hide-mobile">Progress</th>
                                    <th class="hide-tablet">Timeline</th>
                                    <th class="hide-mobile">Status</th>
                                    <th class="hide-desktop">Manager</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project): ?>
                                    <tr>
                                        <td class="project-name"><?php echo $project['name']; ?></td>
                                        <td><?php echo $project['client']; ?></td>
                                        <td class="hide-mobile">
                                            <div class="progress-container small">
                                                <div class="progress-info">
                                                    <span><?php echo $project['progress']; ?>%</span>
                                                </div>
                                                <div class="progress-bar">
                                                    <div class="progress-fill" style="width: <?php echo $project['progress']; ?>%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="hide-tablet">
                                            <div class="timeline-info">
                                                <div>Start: <?php echo $project['startDate']; ?></div>
                                                <div>Due: <?php echo $project['dueDate']; ?></div>
                                            </div>
                                        </td>
                                        <td class="hide-mobile">
                                            <span class="badge <?php echo strtolower(str_replace(' ', '-', $project['status'])); ?>">
                                                <?php echo $project['status']; ?>
                                            </span>
                                        </td>
                                        <td class="hide-desktop">
                                            <div class="manager-info">
                                                <div class="avatar small">
                                                    <?php echo $project['manager']['initials']; ?>
                                                </div>
                                                <span><?php echo $project['manager']['name']; ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-icon dropdown-toggle">⋮</button>
                                                <div class="dropdown-menu">
                                                    <a href="project-details.php?id=<?php echo $project['id']; ?>" class="dropdown-item">
                                                        <span class="icon">👁️</span> View Details
                                                    </a>
                                                    <a href="projects.php?action=edit&id=<?php echo $project['id']; ?>" class="dropdown-item">
                                                        <span class="icon">✏️</span> Edit Project
                                                    </a>
                                                    <a href="#" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this project?')">
                                                        <span class="icon">🗑️</span> Delete Project
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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
