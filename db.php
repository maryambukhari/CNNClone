<?php
$host = 'localhost';
$dbname = 'db37gzt4yjaj2v';
$username = 'uxhc7qjwxxfub';
$password = 'g4t0vezqttq6';

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: Please check your credentials or database setup.");
}
?>
