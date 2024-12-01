<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require '../connect.php'; 

if (!isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit;
}

$username = $_SESSION['username'];

$query = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Data user tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>
    <div class="container">
        <h1>Profile</h1>
        <div class="img">
            <img src="/img/ambalabu.jpg" alt="labubu">
        </div>
        <table>
            <tr>
                <th>ID</th>
                <td><?= $user['id']; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?= $user['username']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $user['email']; ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?= $user['address']; ?></td>
            </tr>
        </table>
        <div class="logout">
            <a href="/logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
