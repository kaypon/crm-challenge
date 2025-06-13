<?php
// Database connection config
$host = '127.0.0.1';
$db   = 'crm';
$user = 'kevin';
$pass = 'password';
$charset = 'utf8mb4';

// Set up DSN and PDO options
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Kill script if DB connection fails
    echo "❌ DB Error: " . $e->getMessage();
    exit;
}
