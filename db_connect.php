<?php
$host = 'localhost';
$port = '5432';  // Change to 5432 if needed
$db = 'car';
$user = 'postgres';
$pass = '123';
$dsn = "pgsql:host=$host;port=$port;dbname=$db";  // Added port

try {
    $conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
