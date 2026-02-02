<?php
session_start();
// Simple authentication check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Clients';

// Include mock data
include_once 'data/mock_data.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarPro - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/clients.css">
</head>
<body>
    <div class="app-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="clients-container">
                <div class="clients-header">
                    <div>
                        <h1>Clients</h1>
                        <p class="text-muted">Manage your client relationships and communications</p>
                    </div>
                    <div class="clients-actions">
                        <div class="search-container">
                            <span class="search-icon">🔍</span>
                            <input type="search" placeholder="Search clients..." class="search-input">
                        </div>
                        <a href="clients.php?action=new" class="btn btn-primary">
                            <span class="icon">+</span> Add Client
                        </a>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th class="hide-mobile">Type</th>
                                <th class="hide-tablet">Contact</th>
                                <th class="hide-desktop">Location</th>
                                <th class="hide-mobile">Projects</th>
                                <th class="actions-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td>
                                        <div class="client-info">
                                            <div class="avatar">
                                                <?php echo $client['initials']; ?>
                                            </div>
                                            <div>
                                                <div class="client-name"><?php echo $client['name']; ?></div>
                                                <div class="client-email hide-mobile">
                                                    <span class="icon">✉️</span>
                                                    <span><?php echo $client['email']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hide-mobile">
                                        <span class="badge outline"><?php echo $client['type']; ?></span>
                                    </td>
                                    <td class="hide-tablet">
                                        <div class="contact-info">
                                            <div><?php echo $client['contact']; ?></div>
                                            <div class="contact-phone">
                                                <span class="icon">📞</span>
                                                <span><?php echo $client['phone']; ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hide-desktop">
                                        <div class="location-info">
                                            <span class="icon">📍</span>
                                            <span class="truncate"><?php echo $client['address']; ?></span>
                                        </div>
                                    </td>
                                    <td class="hide-mobile">
                                        <span class="badge <?php echo $client['status'] === 'Active' ? 'default' : 'outline'; ?>">
                                            <?php echo $client['projects']; ?> <?php echo $client['projects'] === 1 ? 'Project' : 'Projects'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-icon dropdown-toggle">⋮</button>
                                            <div class="dropdown-menu">
                                                <a href="client-details.php?id=<?php echo $client['id']; ?>" class="dropdown-item">
                                                    <span class="icon">👁️</span> View Client
                                                </a>
                                                <a href="clients.php?action=edit&id=<?php echo $client['id']; ?>" class="dropdown-item">
                                                    <span class="icon">✏️</span> Edit Client
                                                </a>
                                                <a href="message.php?client=<?php echo $client['id']; ?>" class="dropdown-item">
                                                    <span class="icon">✉️</span> Send Message
                                                </a>
                                                <a href="#" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this client?')">
                                                    <span class="icon">🗑️</span> Delete Client
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
