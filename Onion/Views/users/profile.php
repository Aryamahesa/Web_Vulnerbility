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

// perbarui session
$_SESSION['id'] = $user_id;
$_SESSION['username'] = $username;

$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($query);

// menampilkan data pengguna
if ($result->num_rows > 0) {    
    $user = $result->fetch_assoc();
} else {
    echo "Data user tidak ditemukan.";
    exit;
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
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>My Profile</h1>
            <a href="/logout.php">Logout</a>
        </div>
        <div class="img">
            <img src="../../public/img/ambalabu.jpg" alt="labubu">
        </div>
        <table>
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
            <tr>
                <th>Saldo</th>
                <td>Rp <?= number_format($user['balance'], 0, ',', '.'); ?></td>
            </tr>
        </table>
    </div>

    <div class="container">
        <a href="/Views/users/payment/transaction.php?id=<?php echo $user['id']; ?>" class="topup-button">Topup Saldo</a>
    </div>

    <!-- <div class="container">
        <div class="account-info">  
            <div class="user-list">
                <h2>Select a User to Chat With:</h2>
                <ul>
                <?php 
                    // Fetch all users except the current user
                    // $sql = "SELECT * FROM users WHERE role = 'user' AND username != '$username'";
                    // $result = $conn->query($sql);
                    // if ($result->num_rows > 0) {
                    //     while ($row = $result->fetch_assoc()) {
                    //         $user = $row['username'];
                    //         $user = ucfirst($user);
                    //         echo "<li><a href='/chat/live_chat.php?user=$user'>$user</a></li>";
                    //     }
                    // }
                    ?>
                </ul>
            </div>
        </div>
    </div> -->
</body>
</html>