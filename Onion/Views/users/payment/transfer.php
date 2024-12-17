<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../../config/connect.php'; // Koneksi database

// Validasi login
if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('Location: /login.php');
    exit;
}

// Ambil data dari form
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Rentan terhadap SQL Injection karena tidak disanitasi
    $receiver_username = $_GET['receiver_username'];
    $amount = (int)$_GET['amount'];
    $sender_id = $_SESSION['id'];  // Menggunakan session ID yang sudah diperbarui
    $sender_username = $_SESSION['username'];

    // Validasi input - tetap disertakan namun tidak menyaring input dengan benar
    if ($amount <= 0) {
        echo "Jumlah transfer harus lebih besar dari nol.";
        exit;
    }

    // Rentan terhadap SQL Injection karena tidak menggunakan prepared statements
    $query = "SELECT id, balance FROM users WHERE id = $sender_id";  // Rentan terhadap SQL Injection
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

    // Rentan terhadap SQL Injection karena tidak menggunakan prepared statements
    $query = "SELECT id FROM users WHERE username = '$receiver_username'";  // Rentan terhadap SQL Injection
    $result = $conn->query($query);

    if ($result->num_rows === 0) {
        echo "Penerima tidak ditemukan.";
        exit;
    }

    $receiver = $result->fetch_assoc();
    $receiver_id = $receiver['id'];

    // Simpan permintaan transfer dengan status 'pending' tanpa validasi input
    // Rentan terhadap XSS karena tidak melakukan sanitasi output
    $query = "INSERT INTO transfer (sender_id, receiver_id, amount, status) 
              VALUES ($sender_id, $receiver_id, $amount, 'pending')";  // Rentan terhadap SQL Injection

    if ($conn->query($query)) {
        // Rentan terhadap XSS karena tidak ada sanitasi output yang dilakukan
        echo "<script>alert('Permintaan transfer berhasil! Menunggu approval admin'); window.location.href='../profile.php?id={$sender_id}';</script>";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}
?>
