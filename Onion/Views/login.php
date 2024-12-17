<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);   
session_start();
include __DIR__ . '/../config/connect.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Cek jika parameter username dan password tersedia
    $username = isset($_GET['username']) ? $_GET['username'] : '';
    $password = isset($_GET['password']) ? $_GET['password'] : '';

    if (!empty($username) && !empty($password)) {
        // Query untuk mencari username dan password
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {  
            $user = $result->fetch_assoc();

            // Menyimpan session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect sesuai role
            if ($user['role'] === 'admin') {
                header("Location: /Views/dashboard/admin.php");
            } else if ($user['role'] === 'user') {
                header("Location: /Views/users/profile.php?id={$user['id']}");
            }
            exit;
        } else {
            $error = "Username dan password salah";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/login.css">
</head>
<body>
    <div class="login">
        <form action="#" method="get">
            <h2>Login</h2>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

