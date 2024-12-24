<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../../config/connect.php'; // Koneksi database

// Ambil data dari form
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Tidak ada sanitasi input, langsung mengambil data dari parameter GET
    $receiver_username = $_GET['receiver_username']; // Tidak disanitasi
    $amount = (int)$_GET['amount'];  // Tidak divalidasi
    $sender_id = $_SESSION['id'];  // Menggunakan session ID yang sudah diperbarui

    // Mengambil saldo pengirim
    $query = "SELECT id, balance FROM users WHERE id = $sender_id"; // Rentan terhadap SQL Injection
    $result = $conn->query($query);

    if ($result->num_rows === 0) {
        echo "Pengguna pengirim tidak ditemukan.";
        exit;
    }

    $sender = $result->fetch_assoc();
    $balance = $sender['balance'];

    // Cek saldo cukup
    if ($balance < $amount) {
        echo "Saldo tidak mencukupi!";
        exit;
    }

    // Mengambil data penerima
    $query = "SELECT id FROM users WHERE username = '$receiver_username'"; // Rentan terhadap SQL Injection
    $result = $conn->query($query);

    if ($result->num_rows === 0) {
        echo "Penerima tidak ditemukan.";
        exit;
    }

    $receiver = $result->fetch_assoc();
    $receiver_id = $receiver['id'];

    // Mulai transaksi untuk memastikan atomicity
    $conn->begin_transaction();

    try {
        // Update saldo pengirim
        $query = "UPDATE users SET balance = balance - $amount WHERE id = $sender_id"; // Rentan terhadap SQL Injection
        $conn->query($query);

        // Update saldo penerima
        $query = "UPDATE users SET balance = balance + $amount WHERE id = $receiver_id"; // Rentan terhadap SQL Injection
        $conn->query($query);

        // Menyelesaikan transaksi transfer
        $query = "INSERT INTO transfer (sender_id, receiver_id, amount, created_at) 
                  VALUES ($sender_id, $receiver_id, $amount, NOW())"; // Rentan terhadap SQL Injection
        $conn->query($query);

        // Commit transaksi
        $conn->commit();

        echo "<script>alert('Transfer berhasil!'); window.location.href='../profile.php?id={$sender_id}';</script>";

    } catch (Exception $e) {
        // Jika ada error, rollback transaksi
        $conn->rollback();
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>
