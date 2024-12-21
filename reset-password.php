<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT );
    $stmt =$conn->prepare("select email from passwordReset where token=? and expires_at > NOW()");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email);
    $stmt->fetch();
    if ($stmt->num_rows > 0 ){

        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param('ss', $password, $email);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM passwordReset WHERE email=?");

        $stmt->bind_param('s', $email);
        $stmt->execute();
        echo "Password reset successful";
        header('Location: login.php');

    } else {
        echo "Invalid or expired token";
    
        } 
    $stmt->close();

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
                    <h3 class="text-center mb-4">Reset Password</h3>
                    <form method="POST" action="reset-password.php">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                        </div> 
                        <button type="submit" class="btn btn-primary w-100"> reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
