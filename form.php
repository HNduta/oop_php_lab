<?php
include_once 'register.php';
include_once 'users.php';
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

