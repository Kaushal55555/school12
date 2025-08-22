<?php

require __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'driver'    => 'mysql',
    'host'      => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'database'  => $_ENV['DB_DATABASE'] ?? 'school',
    'username'  => $_ENV['DB_USERNAME'] ?? 'root',
    'password'  => $_ENV['DB_PASSWORD'] ?? '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
];

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};",
        $config['username'],
        $config['password']
    );
    
    echo "Connected to database successfully!\n";
    
    // Test query
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "\nTables in database:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    
    // Try to insert a test record
    $sql = "INSERT INTO results (student_id, subject_id, class_id, marks, grade, term, academic_year, percentage, created_at, updated_at) 
            VALUES (1, 1, 1, 85, 'A', 'First Term', 2025, 85.00, NOW(), NOW())";
    
    $affected = $pdo->exec($sql);
    
    if ($affected === false) {
        $error = $pdo->errorInfo();
        echo "\nError inserting record: " . ($error[2] ?? 'Unknown error') . "\n";
    } else {
        echo "\nSuccessfully inserted test record!\n";
        $id = $pdo->lastInsertId();
        echo "New record ID: $id\n";
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getCode() . "\n";
}
