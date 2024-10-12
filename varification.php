<?php
include_once 'db_connection.php';
include_once 'users.php';

if (isset($_GET['token'])) {
    $database = new Database(); 
    $db = $database->getConnection(); 

    if ($db === null) {
        die('Database connection failed');
    }

    $user = new User($db);
    $user->verification_token = htmlspecialchars(strip_tags($_GET['token']));

    if ($user->verifyEmail()) {
        echo 'Email verified successfully!';
    } else {
        echo 'Verification failed. Invalid token.';
    }
}
?>