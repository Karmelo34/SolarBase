<?php
// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <div class="logo-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3v2"></path>
                    <path d="M18.5 6.5l-1.41 1.41"></path>
                    <path d="M21 12h-2"></path>
                    <path d="M18.5 17.5l-1.41-1.41"></path>
                    <path d="M12 19v2"></path>
                    <path d="M7 17.5l-1.41 1.41"></path>
                    <path d="M5 12H3"></path>
                    <path d="M7 6.5l-1.41-1.41"></path>
                    <path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"></path>
                </svg>
            </div>
            <h1>SolarPro</h1>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="index.php" class="<?php echo $current_page === 'index.php' ? 'active' : ''; ?>">
                    <span class="icon">🏠</span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="projects.php" class="<?php echo $current_page === 'projects.php' ? 'active' : ''; ?>">
                    <span class="icon">📋</span>
                    <span class="nav-text">Projects</span>
                </a>
            </li>
            <li>
                <a href="tasks.php" class="<?php echo $current_page === 'tasks.php' ? 'active' : ''; ?>">
                    <span class="icon">📅</span>
                    <span class="nav-text">Tasks & Scheduling</span>
                </a>
            </li>
            <li>
                <a href="inventory.php" class="<?php echo $current_page === 'inventory.php' ? 'active' : ''; ?>">
                    <span class="icon">📦</span>
                    <span class="nav-text">Inventory</span>
                </a>
            </li>
            <li>
                <a href="clients.php" class="<?php echo $current_page === 'clients.php' ? 'active' : ''; ?>">
                    <span class="icon">👥</span>
                    <span class="nav-text">Clients</span>
                </a>
            </li>
            <li>
                <a href="documents.php" class="<?php echo $current_page === 'documents.php' ? 'active' : ''; ?>">
                    <span class="icon">📄</span>
                    <span class="nav-text">Documents</span>
                </a>
            </li>
            <li>
                <a href="reports.php" class="<?php echo $current_page === 'reports.php' ? 'active' : ''; ?>">
                    <span class="icon">📊</span>
                    <span class="nav-text">Reports</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <a href="settings.php" class="settings-link">
            <span class="icon">⚙️</span>
            <span>Settings</span>
        </a>
        
        <div class="user-profile">
            <div class="avatar">
                <?php echo isset($_SESSION['username']) ? substr($_SESSION['username'], 0, 2) : 'JD'; ?>
            </div>
            <div class="user-info">
                <p class="user-name"><?php echo $_SESSION['username'] ?? 'John Doe'; ?></p>
                <p class="user-email"><?php echo $_SESSION['email'] ?? 'admin@solarpro.com'; ?></p>
            </div>
        </div>
    </div>
</aside>

<script>
    // Toggle sidebar on mobile
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    });
</script>
