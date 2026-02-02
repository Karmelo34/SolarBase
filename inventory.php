<?php
session_start();
// Simple authentication check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Inventory';

// Include mock data
include_once 'data/mock_data.php';

// Handle category filter
$category_filter = $_GET['category'] ?? 'all';
$filtered_inventory = $inventory;

if ($category_filter !== 'all') {
    $filtered_inventory = array_filter($inventory, function($item) use ($category_filter) {
        return strtolower($item['category']) === strtolower($category_filter);
    });  {
        return strtolower($item['category']) === strtolower($category_filter);
    };
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarPro - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/inventory.css">
</head>
<body>
    <div class="app-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="inventory-container">
                <div class="inventory-header">
                    <div>
                        <h1>Inventory Management</h1>
                        <p class="text-muted">Track and manage your solar equipment and supplies</p>
                    </div>
                    <div class="inventory-actions">
                        <div class="search-container">
                            <span class="search-icon">🔍</span>
                            <input type="search" placeholder="Search inventory..." class="search-input">
                        </div>
                        <div class="filter-container">
                            <select class="filter-select" onchange="window.location.href='inventory.php?category='+this.value">
                                <option value="all" <?php echo $category_filter === 'all' ? 'selected' : ''; ?>>All Items</option>
                                <option value="solar panels" <?php echo $category_filter === 'solar panels' ? 'selected' : ''; ?>>Solar Panels</option>
                                <option value="inverters" <?php echo $category_filter === 'inverters' ? 'selected' : ''; ?>>Inverters</option>
                                <option value="batteries" <?php echo $category_filter === 'batteries' ? 'selected' : ''; ?>>Batteries</option>
                                <option value="mounting" <?php echo $category_filter === 'mounting' ? 'selected' : ''; ?>>Mounting</option>
                                <option value="cables" <?php echo $category_filter === 'cables' ? 'selected' : ''; ?>>Cables</option>
                            </select>
                        </div>
                        <a href="inventory.php?action=new" class="btn btn-primary">
                            <span class="icon">+</span> Add Item
                        </a>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="hide-mobile">Category</th>
                                <th class="hide-tablet">SKU</th>
                                <th>Quantity</th>
                                <th class="hide-desktop">Allocated</th>
                                <th class="hide-mobile">Status</th>
                                <th class="actions-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filtered_inventory as $item): ?>
                                <tr>
                                    <td class="item-name"><?php echo $item['name']; ?></td>
                                    <td class="hide-mobile"><?php echo $item['category']; ?></td>
                                    <td class="hide-tablet"><?php echo $item['sku']; ?></td>
                                    <td>
                                        <div class="quantity-info">
                                            <span class="quantity-available"><?php echo $item['available']; ?></span>
                                            <span class="quantity-total">/ <?php echo $item['quantity']; ?></span>
                                        </div>
                                    </td>
                                    <td class="hide-desktop"><?php echo $item['allocated']; ?></td>
                                    <td class="hide-mobile">
                                        <span class="badge <?php echo strtolower(str_replace(' ', '-', $item['status'])); ?>">
                                            <?php echo $item['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-icon dropdown-toggle">⋮</button>
                                            <div class="dropdown-menu">
                                                <a href="inventory.php?action=edit&id=<?php echo $item['id']; ?>" class="dropdown-item">
                                                    <span class="icon">✏️</span> Edit Item
                                                </a>
                                                <a href="inventory.php?action=update-quantity&id=<?php echo $item['id']; ?>" class="dropdown-item">
                                                    <span class="icon">🔄</span> Update Quantity
                                                </a>
                                                <a href="#" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                                                    <span class="icon">🗑️</span> Delete Item
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
