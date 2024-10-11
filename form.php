<?php
include_once 'register.php';
include_once 'user.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database(); // Create a new instance of the Database class
    $db = $database->getConnection(); // Get the database connection

    if ($db === null) {
        die('Database connection failed');
    }

    $user = new User($db); 

    $user->firstname = htmlspecialchars(strip_tags($_POST['firstname']));
    $user->lastname = htmlspecialchars(strip_tags($_POST['lastname']));
    $user->email = htmlspecialchars(strip_tags($_POST['email']));
    $user->password = htmlspecialchars(strip_tags($_POST['password']));
    $user->verification_token = bin2hex(random_bytes(16));

    if ($user->create()) {
        // Send verification email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            
            $mail->Host = 'smtp.gmail.com';                
            $mail->SMTPAuth   = true;                               
            $mail->Username   = 'iannganga154@gmail.com';       
            $mail->Password   = 'euel dpjz whzh lvoa';             
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
            $mail->Port       = 587;                                

            //Recipients
            $mail->setFrom('your_email@gmail.com', 'Mailer');
            $mail->addAddress($user->email);                  

            // Content
            $mail->isHTML(true);          
            $mail->Subject = 'Verify your email address';
            $mail->Body    = "Click <a href='http://your_domain.com/verify.php?token={$user->verification_token}'>here</a> to verify your email address.";

            $mail->send();
            echo 'Verification email sent. Please check your inbox.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Unable to create user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Register</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Register</h2>
        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>