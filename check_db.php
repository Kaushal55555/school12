<?php

require __DIR__.'/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration
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
    // Create PDO connection
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Successfully connected to the database.\n";
    
    // List all tables
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "\nTables in database '{$config['database']}':\n";
        foreach ($tables as $table) {
            echo "- $table\n";
        }
    } else {
        echo "\nNo tables found in the database.\n";
    }
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage() . "\n");
}
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

try {
    // Test the connection
    $pdo = $db->getConnection()->getPdo();
    echo "✅ Successfully connected to the database!\n";
    
    // List all tables
    $tables = $db->select('SHOW TABLES');
    echo "\n📋 Tables in the database:\n";
    
    if (empty($tables)) {
        echo "No tables found in the database.\n";
    } else {
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            echo "- $tableName\n";
        }
    }
    
    // Check if the results table exists and its structure
    $resultsTableExists = $db->getSchemaBuilder()->hasTable('results');
    echo "\n🔍 Results table exists: " . ($resultsTableExists ? 'Yes' : 'No') . "\n";
    
    if ($resultsTableExists) {
        $columns = $db->getSchemaBuilder()->getColumnListing('results');
        echo "\n📊 Results table columns:\n";
        foreach ($columns as $column) {
            echo "- $column\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getCode() . "\n";
    
    if (str_contains($e->getMessage(), 'SQLSTATE')) {
        echo "SQL State: " . $e->getCode() . "\n";
    }
    
    // Additional debugging for common issues
    if (str_contains($e->getMessage(), 'Access denied')) {
        echo "\n🔑 Check your database credentials in the .env file.\n";
        echo "Current configuration:\n";
        echo "- DB_HOST: " . $config['host'] . "\n";
        echo "- DB_DATABASE: " . $config['database'] . "\n";
        echo "- DB_USERNAME: " . $config['username'] . "\n";
    }
    
    if (str_contains($e->getMessage(), 'Unknown database')) {
        echo "\n❌ The specified database does not exist. Please create it first.\n";
    }
}
