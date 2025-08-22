<?php

// Database configuration
$host = '127.0.0.1';
$db   = 'school_result_management';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "✅ Successfully connected to the database!\n\n";
    
    // List all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "📋 Tables in database '$db':\n";
        foreach ($tables as $table) {
            echo "- $table\n";
        }
    } else {
        echo "ℹ️ No tables found in the database.\n";
    }
    
} catch (\PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage() . "\n");
}
