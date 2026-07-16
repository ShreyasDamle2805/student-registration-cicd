<?php

$host = getenv('DB_HOST') ?: 'mariadb-service';
$user = getenv('DB_USER') ?: 'studentuser';
$password = getenv('DB_PASSWORD') ?: 'studentpass';
$dbname = getenv('DB_NAME') ?: 'studentdb';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    die("Database connection failed.");
}