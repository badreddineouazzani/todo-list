<?php

include 'db.php';
include 'send_mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id);
        $reset_token = bin2hex(random_bytes(16));
        $expiry =date('Y-m-d H:i:s',strtotime("+1 hour"));
        $stmt = $conn->prepare("INSERT INTO passwordReset (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $email, $reset_token, $expiry);
        $stmt->execute();
        $stmt->close();
        $reset_link = "http://localhost/CWO/reset-password.php?token=".$reset_token;
        $to = $email;
        $subject = "Reset Password";
        $body = "Click <a href='$reset_link'>here</a> to reset your password";
        sendMail($to, $subject, $body);
        echo "Password reset link has been sent to your email. Please check your inbox.";
    }else{
        echo "Email not found";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            margin-top: 50px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="form-container">
                    <h3 class="text-center mb-4">Forgot Password</h3>
                    <form method="POST" action="forgot-password.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                        </div> 
                        <button type="submit" class="btn btn-primary w-100">send reset link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
