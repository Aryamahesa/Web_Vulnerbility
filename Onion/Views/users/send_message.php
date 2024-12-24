<?php
session_start();
include __DIR__ . '/../../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // Tidak memeriksa apakah session ini valid
    $data = json_decode(file_get_contents('php://input'), true);

    // Tanpa validasi atau sanitasi input
    $receiverId = $data['receiver_id'];
    $message = $data['message'];

    // Query langsung tanpa prepared statement (rentan SQL Injection)
    $query = "INSERT INTO chat (user_id, receiver_id, message) VALUES ($userId, $receiverId, '$message')";
    $conn->query($query); // Eksekusi langsung (rentan)

    echo json_encode(['success' => true]); // Output tanpa validasi
}
?>
