<?php

$host = getenv('DB_HOST') ?: '172.31.26.163';
$database = getenv('DB_NAME') ?: 'student_portal';
$username = getenv('DB_USER') ?: 'student_app';
$password = getenv('DB_PASSWORD') ?: 'student1234';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$database};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $exception) {
    error_log('Database connection failed: ' . $exception->getMessage());
    http_response_code(500);
    exit('Database connection failed.');
}