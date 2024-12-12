<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include __DIR__ . '/../../../config/connect.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
header('Location: /login.php');
exit;
}

// Ambil data dari form
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validasi keberadaan parameter 'amount'
    if (!isset($_GET['amount'])) {
        echo "Parameter 'amount' tidak ditemukan.";
        exit;
    }

    $amount = $_GET['amount'];
    $username = $_SESSION['username'];

    // Validasi jumlah top-up
    if (!is_numeric($amount) || $amount <= 0) {
        echo "Jumlah top-up harus lebih besar dari nol.";
        exit;
    }

    // Ambil user_id dari session
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Simpan permintaan top-up ke tabel topups dengan status 'pending'
        $query = "INSERT INTO topup (user_id, amount, status) VALUES ('$user_id', '$amount', 'pending')";

        if ($conn->query($query)) {
            echo "<script>alert('Permintaan top-up berhasil! Menunggu approval'); window.location.href='../profile.php';</script>";
        } else {
            echo "Terjadi kesalahan: " . $conn->error;
        }
    } else {
        echo "Pengguna tidak ditemukan.";
    }
}
?>
