<?php
include_once 'register.php';
include_once 'user.php';

if (isset($_GET['token'])) {
    $database = new Database(); 
    $db = $database->getConnection(); 

    if ($db === null) {
        die('Database connection failed');
    }

    $user = new User($db);
    $user->verification_token = htmlspecialchars(strip_tags($_GET['token']));

    // Call the verifyEmail method of the User class to verify the token.
    if ($user->verifyEmail()) {
        echo 'Email verified successfully!';
    } else {
        echo 'Verification failed. Invalid token.';
    }
}
?>