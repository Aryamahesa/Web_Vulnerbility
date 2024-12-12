<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../../config/connect.php'; // Koneksi database

// Validasi login
if (!isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit;
}

// Ambil data dari form
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $receiver_username = $_GET['receiver_username'];
    $amount = (int)$_GET['amount'];
    $sender_username = $_SESSION['username'];

    // Validasi input
    if ($amount <= 0) {
        echo "Jumlah transfer harus lebih besar dari nol.";
        exit;
    }

    // Ambil data pengguna pengirim
    $query = "SELECT id, balance FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $sender_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Pengguna pengirim tidak ditemukan.";
        exit;
    }

    $sender = $result->fetch_assoc();
    $sender_id = $sender['id'];
    $balance = $sender['balance'];

    // Cek saldo cukup
    if ($balance < $amount) {
        echo "Saldo tidak mencukupi!";
        exit;
    }

    // Ambil data pengguna penerima
    $query = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $receiver_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Penerima tidak ditemukan.";
        exit;
    }

    $receiver = $result->fetch_assoc();
    $receiver_id = $receiver['id'];

    // Simpan permintaan transfer dengan status 'pending'
    $query = "INSERT INTO transfer (sender_id, receiver_id, amount, status) VALUES (?, ?, ?, 'pending')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iii', $sender_id, $receiver_id, $amount);

    if ($stmt->execute()) {
        echo "<script>alert('Permintaan transfer berhasil! Menunggu approval admin'); window.location.href='../profile.php';</script>";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }
}
