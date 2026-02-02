<?php
session_start();



// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple authentication (in a real app, you'd check against a database)
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 'John Doe';
        $_SESSION['email'] = 'admin@solarpro.com';
        $_SESSION['role'] = 'admin';
        
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarPro - Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-header">
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
            <p>Solar Installation Project Management</p>
        </div>
        
        <div class="login-form-container">
            <h2>Login to your account</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="login.php" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                        Remember me
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </form>
            
            <div class="login-footer">
                <p>Demo credentials: admin / password</p>
            </div>
        </div>
    </div>
</body>
</html>
