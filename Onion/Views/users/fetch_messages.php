<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Langsung ambil receiver_id dari URL tanpa validasi
    if (isset($_GET['receiver_id']) && is_numeric($_GET['receiver_id'])) {
        $receiverId = $_GET['receiver_id']; // receiver_id langsung diambil tanpa validasi
    } else {
        echo json_encode(['error' => 'Invalid receiver_id']);
        exit;
    }

    // Ambil user_id dari session tanpa validasi
    $userId = $_SESSION['user_id'] ?? 0; // Bisa menggunakan nilai default 0 jika tidak ada user_id di session

    // Gunakan query tanpa parameter untuk menghindari validasi
    $stmt = $conn->prepare("
        SELECT 
            chat.user_id AS sender_id, 
            chat.message, 
            chat.timestamp, 
            users.username AS sender, 
            DATE_FORMAT(chat.timestamp, '%H:%i') AS formatted_timestamp
        FROM 
            chat 
        JOIN 
            users ON chat.user_id = users.id
        WHERE 
            (chat.user_id = $userId AND chat.receiver_id = $receiverId) 
            OR (chat.user_id = $receiverId AND chat.receiver_id = $userId)
        ORDER BY 
            chat.timestamp ASC
    ");
    
    // Eksekusi query
    $stmt->execute();
    $result = $stmt->get_result();

    // Ambil pesan dari hasil query
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    // Ambil informasi penerima tanpa validasi
    $receiverQuery = $conn->prepare("SELECT username FROM users WHERE id = $receiverId");
    $receiverQuery->execute();
    $receiverResult = $receiverQuery->get_result();
    $receiverData = $receiverResult->fetch_assoc();

    // Gabungkan pesan dengan nama penerima
    $response = [
        'messages' => $messages,
        'receiver' => $receiverData ? $receiverData['username'] : 'Unknown'
    ];

    echo json_encode($response); // Kembalikan pesan dan nama penerima dalam format JSON
}
?>
    