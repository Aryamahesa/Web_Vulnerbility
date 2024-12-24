<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// ambil parameter dari url 
$user_id = $_GET['id'];

$_SESSION['id'] = $user_id;  // Store the user's id

$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($query);

// menampilkan data pengguna
if ($result->num_rows > 0) {    
    $user = $result->fetch_assoc();
}

?>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="/../../public/css/profile.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>My Profile</h1>
            <a href="/logout.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="img">
            <img src="../../public/img/photo-profile.jpeg" alt="labubu">
        </div>
        <table>
            <tr>
                <th>Username</th>
                <td>: <?= $user['username']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td>: <?= $user['email']; ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td>: <?= $user['address']; ?></td>
            </tr>
            <tr>
                <th>Saldo</th>
                <td>: Rp <?= number_format($user['balance'], 0, ',', '.'); ?></td>
            </tr>
        </table>
    </div>

    <div class="container">
        <div class="feature-content">
            <a href="/Views/users/payment/transaction.php?id=<?php echo $user['id']; ?>" class="topup-button">
                <span class="material-icons" style="font-size: 2rem">account_balance_wallet</span>
            </a>
            <a href="chat.php" class="chat-button">
                <span class="material-icons" style="font-size: 2rem">chat</span>
            </a>
        </div>
    </div>
</body>
</html>