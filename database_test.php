<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Facades\Config;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration
$config = [
    'driver'    => 'mysql',
    'host'      => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'database'  => $_ENV['DB_DATABASE'] ?? 'school_result_management',
    'username'  => $_ENV['DB_USERNAME'] ?? 'root',
    'password'  => $_ENV['DB_PASSWORD'] ?? '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
];

// Set up the database connection
$db = new DB;
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

try {
    // Test the connection
    $pdo = $db->getConnection()->getPdo();
    echo "Successfully connected to the database!\n";
    
    // List all tables
    $tables = $db->select('SHOW TABLES');
    echo "\nTables in the database:\n";
    foreach ($tables as $table) {
        $tableName = array_values((array)$table)[0];
        echo "- $tableName\n";
    }
    
    // Try to insert a test record
    $testData = [
        'student_id' => 1,
        'subject_id' => 1,
        'class_id' => 1,
        'marks' => 85,
        'grade' => 'A',
        'term' => 'First Term',
        'academic_year' => 2025,
        'percentage' => 85.00,
        'created_at' => now(),
        'updated_at' => now(),
    ];
    
    $inserted = $db->table('results')->insert($testData);
    if ($inserted) {
        echo "\nSuccessfully inserted test record!\n";
        $id = $db->getPdo()->lastInsertId();
        echo "New record ID: $id\n";
    } else {
        echo "\nFailed to insert test record.\n";
    }
    
} catch (\Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getCode() . "\n";
    if (str_contains($e->getMessage(), 'SQLSTATE')) {
        echo "SQL State: " . $e->getCode() . "\n";
    }
}
