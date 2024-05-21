<?php
// Define the path to the .env file
$envFilePath =  '../.env';

if (!file_exists($envFilePath)) {
    die('.env file does not exist');
}

// Read the .env file line by line and populate the $_ENV array
$lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (str_starts_with($line, '#')) {
        continue; // Skip comments
    }
    
    list($name, $value) = explode('=', $line, 2);
    $_ENV[$name] = $value;
}

// Extract configuration values
$dbHost = $_ENV['DB_HOST'] ?? 'localhost';
$dbName = $_ENV['DB_NAME'] ?? 'my_database';
$dbUser = $_ENV['DB_USER'] ?? 'my_user';
$dbPassword = $_ENV['DB_PASSWORD'] ?? 'my_password';
$dbPort = $_ENV['DB_PORT'] ?? '3306';

// Create a DSN string
$dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName";

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
} catch (PDOException $e) {
    die("Could not connect to the database. Error: " . $e->getMessage());
}

// Return the PDO instance
return $pdo;