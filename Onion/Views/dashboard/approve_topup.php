<?php
include __DIR__ . '/../../config/connect.php';

// Ambil ID dan action dari parameter URL
$id = $_GET['id'];
$action = $_GET['action'];

// Tentukan status berdasarkan action
$status = ($action === 'approve') ? 'approved' : 'rejected';

$query = "SELECT * FROM topup WHERE id = '$id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $topup = $result->fetch_assoc();
    $user_id = $topup['user_id'];
    $amount = $topup['amount'];

    if ($status === 'approved') {
        // Tambahkan saldo pengguna
        $updateUserQuery = "UPDATE users SET balance = balance + $amount WHERE id = $user_id";
        $conn->query($updateUserQuery);
    }

    // Perbarui status transaksi top-up 
    $updateTopupQuery = "UPDATE topup SET status = '$status' WHERE id = '$id'";
    $conn->query($updateTopupQuery);
}

// Redirect kembali ke dashboard admin
header('Location: /Views/dashboard/status.php');
exit;
?>
