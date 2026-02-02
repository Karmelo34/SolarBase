<?php
/**
 * Database configuration
 * 
 * This file contains database connection settings.
 * In a production environment, these values should be stored in environment variables.
 */

// Database connection settings
define('DB_HOST', 'localhost');  
define('DB_NAME', 'solar_management');
define('DB_USER', 'root'); 
define('DB_PASS', '');  
define('DB_CHARSET', 'utf8mb4');

/**
 * Get database connection
 * 
 * @return PDO Database connection
 */
function getDbConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        throw new Exception("Database connection failed. Please try again later.");
    }
}

/**
 * Check if database connection is available
 * 
 * @return bool True if connection is available, false otherwise
 */
function isDatabaseAvailable() {
    try {
        $conn = getDbConnection();
        return $conn !== null;
    } catch (Exception $e) {
        return false;
    }
}