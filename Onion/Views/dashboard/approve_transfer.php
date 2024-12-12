<?php
include __DIR__ . '/../../config/connect.php';

// Ambil ID dan action dari parameter URL
$id = $_GET['id'];
$action = $_GET['action'];

// Tentukan status berdasarkan action
$status = ($action === 'approve') ? 'approved' : 'rejected';

$query = "SELECT * FROM transfer WHERE id = '$id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $transfer = $result->fetch_assoc();
    $sender_id = $transfer['sender_id'];
    $receiver_id = $transfer['receiver_id'];
    $amount = $transfer['amount'];

    if ($status === 'approved') {
        // Kurangkan saldo pengguna
        $updateSenderQuery = "UPDATE users SET balance = balance - $amount WHERE id = $sender_id";
        $conn->query($updateSenderQuery);

        $updateReceiverQuery = "UPDATE users SET balance = balance + $amount WHERE id = $receiver_id";
        $conn->query($updateReceiverQuery);
    }

    // Perbarui status transaksi transfer
    $updateTransferQuery = "UPDATE transfer SET status = '$status' WHERE id = '$id'";
    $conn->query($updateTransferQuery);
}

// Redirect kembali ke dashboard admin
header('Location: /Views/dashboard/status.php');
exit;
?>
