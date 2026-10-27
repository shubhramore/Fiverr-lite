<?php
session_start();

$host = "localhost";
$db   = "freelance_marketplace";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database connection failed. Import database/schema.sql and check XAMPP MySQL.");
}

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
function logged_in() {
    return isset($_SESSION['user']);
}
function require_login() {
    if (!logged_in()) {
        header("Location: login.php");
        exit;
    }
}
function flash($type, $message) {
    $_SESSION['flash'] = [$type, $message];
}
function show_flash() {
    if (!empty($_SESSION['flash'])) {
        [$type, $message] = $_SESSION['flash'];
        echo '<div class="alert '.e($type).'">'.e($message).'</div>';
        unset($_SESSION['flash']);
    }
}
