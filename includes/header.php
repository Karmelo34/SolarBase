<header class="main-header">
    <div class="header-left">
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <h2 class="page-title"><?php echo $page_title; ?></h2>
    </div>
    
    <div class="header-right">
        <div class="header-search">
            <input type="search" placeholder="Search..." class="search-input">
            <button class="search-button">🔍</button>
        </div>
        
        <div class="header-actions">
            <div class="dropdown">
                <button class="btn btn-icon notification-btn dropdown-toggle">
                    🔔
                    <span class="notification-badge">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">
                        <h3>Notifications</h3>
                        <a href="#" class="mark-all-read">Mark all as read</a>
                    </div>
                    <div class="dropdown-items">
                        <a href="#" class="dropdown-item notification-item unread">
                            <div class="notification-icon">📋</div>
                            <div class="notification-content">
                                <p>New project has been created</p>
                                <span class="notification-time">2 hours ago</span>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item notification-item unread">
                            <div class="notification-icon">📅</div>
                            <div class="notification-content">
                                <p>Task "Site Assessment" is due tomorrow</p>
                                <span class="notification-time">5 hours ago</span>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item notification-item unread">
                            <div class="notification-icon">📦</div>
                            <div class="notification-content">
                                <p>Inventory alert: Low stock on Solar Panels</p>
                                <span class="notification-time">Yesterday</span>
                            </div>
                        </a>
                    </div>
                    <div class="dropdown-footer">
                        <a href="notifications.php">View all notifications</a>
                    </div>
                </div>
            </div>
            
            <div class="dropdown">
                <button class="btn btn-icon user-menu-btn dropdown-toggle">
                    <div class="avatar small">
                        <?php echo isset($_SESSION['username']) ? substr($_SESSION['username'], 0, 2) : 'JD'; ?>
                    </div>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="profile.php" class="dropdown-item">
                        <span class="icon">👤</span> My Profile
                    </a>
                    <a href="settings.php" class="dropdown-item">
                        <span class="icon">⚙️</span> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item">
                        <span class="icon">🚪</span> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Toggle mobile menu
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.querySelector('.sidebar');
        
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
        });
    });
</script>
