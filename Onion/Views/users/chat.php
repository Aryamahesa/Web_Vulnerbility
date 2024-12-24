<?php
session_start();
include __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$id = $_SESSION['user_id']; // ID pengguna yang login

// Ambil daftar semua pengguna kecuali pengguna yang sedang login
$query = "SELECT * FROM users WHERE role = 'user' AND id != '$id'";
$result = $conn->query($query);

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM users WHERE role = 'user' AND id != '$id' AND username LIKE '%$search%'";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat</title>
    <link rel="stylesheet" href="/../../public/css/chat.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="chat-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <form method="GET" action="" class="chat-form">
                <h1>Chats</h1>
                <a href="profile.php?id=<?= isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>" class="back-menu">
                    <i class="fas fa-sign-out-alt"></i> Back Profile
                </a>
            </form>
            <form method="GET" action="" class="search-form">
                <input type="text" name="search" placeholder="Search..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="search-input">
                <i class="fa-solid fa-magnifying-glass search-form-icon"></i>
            </form>
            <nav class="menu">
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $query = "SELECT * FROM users WHERE role = 'user' AND id != '$id' AND username LIKE '%$search%'";
                $result = $conn->query($query);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $user = $row['username'];
                        $receiverId = $row['id'];
                        echo '<div class="profile-section">';
                        echo '<img src="../../public/img/photo-profile.jpeg" alt="Profile Picture" class="profile-picture">';
                        echo '<a href="?receiver_id=' . $receiverId . '"><span class="profile-name">' . $user . '</span></a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No users found</p>';
                }
                ?>
            </nav>
        </aside>


        <!-- Main Chat -->
        <main class="chat-main">
            <div class="chat-header">
                <img src="../../public/img/photo-profile.jpeg" alt="Profile Picture">
                <h2><?php 
                    if (isset($_GET['receiver_id'])) {
                        $receiverId = $_GET['receiver_id'];

                        // Query untuk mengambil nama pengguna berdasarkan receiver_id
                        $query = "SELECT username FROM users WHERE id = '$receiverId'";
                        $result = $conn->query($query);
                        
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo htmlspecialchars($row['username']);
                        } else {
                            echo "User not found";
                        }
                    } else {
                        echo "Chat With ..."; 
                    }
                ?></h2>
            </div>
            <div class="chat-content" id="messages">
                <!-- Pesan akan dimuat menggunakan AJAX -->
            </div>
            <form id="chatForm" class="chat-footer">
                <textarea id="message" placeholder="Ketik pesan Anda di sini..."></textarea>
                <button type="submit" class="send-btn">Kirim</button>
            </form>
        </main>
    </div>

    <!-- Script JavaScript -->
    <script>
        const receiverId = new URLSearchParams(window.location.search).get('receiver_id');

        function loadMessages() {
            if (!receiverId) return;

            fetch(`fetch_messages.php?receiver_id=${receiverId}`)
                .then(response => response.json())
                .then(data => {
                    const chatContent = document.getElementById('messages');
                    chatContent.innerHTML = '';

                    data.messages.forEach(msg => {
                        const isOutgoing = parseInt('<?php echo $_SESSION["user_id"]; ?>') === msg.sender_id;
                        const messageClass = isOutgoing ? 'outgoing' : 'incoming';
                        const bubbleClass = isOutgoing ? 'outgoing-bubble' : 'incoming-bubble';

                        chatContent.innerHTML += `
                            <div class="message ${messageClass}">
                                <div class="bubble ${bubbleClass}">
                                    <span>${msg.message}</span>
                                    <span class="message-time">${msg.formatted_timestamp}</span>
                                </div>
                            </div>`;
                    });
                });
        }

        setInterval(loadMessages, 1000);

        document.getElementById('chatForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const message = document.getElementById('message').value.trim();

            if (!message || !receiverId) {
                alert('Message cannot be empty!');
                return;
            }

            fetch('send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ receiver_id: receiverId, message: message })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('message').value = '';
                    loadMessages();
                } else {
                    alert('Error: ' + (data.error || 'Unable to send message.'));
                }
            });
        });
    </script>
</body>
</html>
