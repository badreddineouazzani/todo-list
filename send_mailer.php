<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendMail($to, $subject, $message){

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       ='smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'email@gmail.com';
        $mail->Password   = 'password';
        $mail->SMTPSecure = PHPMAILER::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('email@gmail.com', 'todo-list');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
        echo "Email sent successfully";
        return true;
    } catch (Exeption $e) {
        echo "Error: $e";
        return false;
    }
}