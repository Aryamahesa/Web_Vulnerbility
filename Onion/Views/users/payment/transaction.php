<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();

    // Koneksi database
    include __DIR__ . '/../../../config/connect.php';

    // Cek apakah pengguna sudah login
    if (!isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/../../../public/css/topup.css">
</head>
<body>
    <div class="container-topup">
        <!-- Form Topup -->
        <div class="account-info">
                <h2>Topup Saldo</h2>
                <form action="/Views/users/payment/topup.php" method="GET" class="user-list">
                    <label>Jumlah Topup:</label>
                    <input type="number" name="amount"><br><br>
                    <input type="submit" value="Topup">
                </form>
            </div>
            
            <!-- Form Transfer -->
            <div class="account-info">
                <h2>Transfer Saldo</h2>
                <form action="transfer.php" method="GET" class="user-list">
                    <label>Penerima:</label>
                    <input type="text" name="receiver_username"><br><br>
                    <label>Jumlah Transfer:</label>
                    <input type="number" name="amount"><br><br>
                    <input type="submit" value="Transfer">
                </form>
            </div>
    </div>
</body>
</html>

<?php
// include __DIR__ . "/topup.php";
?>