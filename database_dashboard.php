<?php
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'register.php';
include_once 'user.php';

$database = new Database();
$db = $database->getConnection();

if ($db === null) {
    die('Database connection failed');
}


$users = new User($db);

$users->email = $_SESSION['email'];
$stmt = $users->readByEmail(); 

if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "<h2>Welcome, {$firstname} {$lastname}!</h2>";
    echo "<p>Email: {$email}</p>";
    echo "<p>Account created on: {$created_at}</p>"; 
} else {
    echo "<p>User not found.</p>";
}
?>