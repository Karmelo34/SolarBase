<?php
session_start();
// Simple authentication check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Documents';

// Include mock data
include_once 'data/mock_data.php';

// Handle type filter
$type_filter = $_GET['type'] ?? 'all';
$filtered_documents = $documents;

if ($type_filter !== 'all') {
    $filtered_documents = array_filter($documents, function($doc) use ($type_filter) {
        return strtolower($doc['type']) === strtolower($type_filter);
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
    <link rel="stylesheet" href="css/documents.css">
</head>
<body>
    <div class="app-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="documents-container">
                <div class="documents-header">
                    <div>
                        <h1>Documents</h1>
                        <p class="text-muted">Manage permits, warranties, and compliance documents</p>
                    </div>
                    <div class="documents-actions">
                        <div class="search-container">
                            <span class="search-icon">🔍</span>
                            <input type="search" placeholder="Search documents..." class="search-input">
                        </div>
                        <div class="filter-container">
                            <select class="filter-select" onchange="window.location.href='documents.php?type='+this.value">
                                <option value="all" <?php echo $type_filter === 'all' ? 'selected' : ''; ?>>All Documents</option>
                                <option value="permit" <?php echo $type_filter === 'permit' ? 'selected' : ''; ?>>Permits</option>
                                <option value="warranty" <?php echo $type_filter === 'warranty' ? 'selected' : ''; ?>>Warranties</option>
                                <option value="contract" <?php echo $type_filter === 'contract' ? 'selected' : ''; ?>>Contracts</option>
                                <option value="compliance" <?php echo $type_filter === 'compliance' ? 'selected' : ''; ?>>Compliance</option>
                            </select>
                        </div>
                        <a href="documents.php?action=upload" class="btn btn-primary">
                            <span class="icon">↑</span> Upload
                        </a>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Document</th>
                                <th class="hide-mobile">Project</th>
                                <th class="hide-tablet">Type</th>
                                <th class="hide-desktop">Uploaded</th>
                                <th class="hide-mobile">Status</th>
                                <th class="actions-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filtered_documents as $document): ?>
                                <tr>
                                    <td>
                                        <div class="document-info">
                                            <div class="document-icon">
                                                <span class="icon">📄</span>
                                            </div>
                                            <div>
                                                <div class="document-name"><?php echo $document['name']; ?></div>
                                                <div class="document-size"><?php echo $document['size']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hide-mobile"><?php echo $document['project']; ?></td>
                                    <td class="hide-tablet">
                                        <span class="badge outline"><?php echo $document['type']; ?></span>
                                    </td>
                                    <td class="hide-desktop">
                                        <div class="upload-info">
                                            <div><?php echo $document['uploadDate']; ?></div>
                                            <div class="upload-by">by <?php echo $document['uploadedBy']; ?></div>
                                        </div>
                                    </td>
                                    <td class="hide-mobile">
                                        <span class="badge <?php echo in_array($document['status'], ['Approved', 'Valid', 'Signed']) ? 'success' : ($document['status'] === 'Pending' ? 'outline' : 'default'); ?>">
                                            <?php echo $document['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-icon dropdown-toggle">⋮</button>
                                            <div class="dropdown-menu">
                                                <a href="documents/download.php?id=<?php echo $document['id']; ?>" class="dropdown-item">
                                                    <span class="icon">⬇️</span> Download
                                                </a>
                                                <a href="documents/share.php?id=<?php echo $document['id']; ?>" class="dropdown-item">
                                                    <span class="icon">🔗</span> Share
                                                </a>
                                                <a href="documents.php?action=rename&id=<?php echo $document['id']; ?>" class="dropdown-item">
                                                    <span class="icon">✏️</span> Rename
                                                </a>
                                                <a href="#" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this document?')">
                                                    <span class="icon">🗑️</span> Delete
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
