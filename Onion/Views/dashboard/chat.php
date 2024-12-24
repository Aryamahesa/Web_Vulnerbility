<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../config/connect.php';

// Cek apakah admin login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /login.php');
    exit;
}

// Konfigurasi pagination
$limit = 10; // Jumlah pesan per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Query untuk menghitung total pesan
$countQuery = "
    SELECT COUNT(*) AS total 
    FROM chat c
    JOIN users u1 ON c.user_id = u1.id
    JOIN users u2 ON c.receiver_id = u2.id
";
if ($search !== '') {
    $countQuery .= " WHERE u1.username LIKE '%$search%'";
}

$countResult = $conn->query($countQuery);
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// Query untuk mengambil data pesan dengan filter dan limit
$query = "
    SELECT 
        c.id,
        u1.username AS sender_username,
        u2.username AS receiver_username,
        c.message,
        c.timestamp
    FROM chat c
    JOIN users u1 ON c.user_id = u1.id
    JOIN users u2 ON c.receiver_id = u2.id
";
if ($search !== '') {
    $query .= " WHERE u1.username LIKE '%$search%'";
}
$query .= " ORDER BY c.timestamp DESC LIMIT $limit OFFSET $offset";

$result = $conn->query($query);

$current_page = basename($_SERVER['PHP_SELF']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Chats</title>
    <link rel="stylesheet" href="/../../public/css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="sidebar">
<div class="sidebar-header">
        <img src="../../public/img/onion-logo.png" alt="Logo" class="logo">
    </div>
    <ul class="sidebar-menu">
        <a href="index.php" class="menu-item <?= $current_page == 'index.php' ? 'active' : '' ?>"><i class="fas fa-fw fa-tachometer-alt"></i> Dashboard</a>
        <a href="users.php" class="menu-item <?= $current_page == 'users.php' ? 'active' : '' ?>"><i class="fas fa-users"></i> Users</a>
        <a href="#" class="menu-item <?= $current_page == 'chat.php' ? 'active' : '' ?>"><i class="fas fa-comment-alt"></i></i> Chat</a>
        <a href="transfer.php" class="menu-item <?= $current_page == 'transfer.php' ? 'active' : '' ?>"><i class="fa-solid fa-money-bill-transfer"></i> Transfer</a>
        <a href="status.php" class="menu-item <?= $current_page == 'status.php' ? 'active' : '' ?>"><i class="fa-solid fa-wallet"></i></i> Topup</a>
        <a href="/logout.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </ul>
</div>
<div class="main-content">
    <h1>User Chats</h1>

    <!-- Form Pencarian -->
    <form method="GET" action="" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Search by sender name" value="<?= $search?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th class="rounded-header-top-left">ID</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Message</th>
                <th class="rounded-header-top-right">Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($chat = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $chat['id'] ?></td>
                        <td><?= $chat['sender_username'] ?></td>
                        <td><?= $chat['receiver_username'] ?></td>
                        <td><?= $chat['message'] ?></td>
                        <td><?= $chat['timestamp'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No chat messages found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination" style="margin-top: 20px; text-align: center;">
        <?php if ($page > 1): ?>
            <a href="?search=<?= $search ?>&page=<?= $page - 1 ?>" class="pagination-link">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?search=<?= $search ?>&page=<?= $i ?>" 
               class="pagination-link <?= $i == $page ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?search=<?= $search ?>&page=<?= $page + 1 ?>" class="pagination-link">Next</a>
        <?php endif; ?>
    </div>
</div>
<script>
    // Tambahkan event listener untuk semua menu item
    const menuItems = document.querySelectorAll('.menu-item');

    menuItems.forEach(item => {
        item.addEventListener('click', function () {
            // Hapus kelas active dari semua menu item
            menuItems.forEach(menu => menu.classList.remove('active'));

            // Tambahkan kelas active pada menu yang diklik
            this.classList.add('active');
        });
    });
</script>
</body>
</html>
