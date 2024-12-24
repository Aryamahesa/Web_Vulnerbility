<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /login.php');
    exit;
}

// Ambil permintaan top-up dan transfer yang belum disetujui
$query = "SELECT * FROM users";
$result = $conn->query($query);

// include __DIR__ . "/header.php";

$current_page = basename($_SERVER['PHP_SELF']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/../../public/css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<!-- Sidebar Menu -->
<div class="sidebar">
<div class="sidebar-header">
        <img src="../../public/img/onion-logo.png" alt="Logo" class="logo">
    </div>
    <ul class="sidebar-menu">
        <a href="index.php" class="menu-item <?= $current_page == 'index.php' ? 'active' : '' ?>"><i class="fas fa-fw fa-tachometer-alt"></i> Dashboard</a>
        <a href="#" class="menu-item <?= $current_page == 'users.php' ? 'active' : '' ?>"><i class="fas fa-users"></i> Users</a>
        <a href="chat.php" class="menu-item <?= $current_page == 'chat.php' ? 'active' : '' ?>"><i class="fas fa-comment-alt"></i></i> Chat</a>
        <a href="transfer.php" class="menu-item <?= $current_page == 'transfer.php' ? 'active' : '' ?>"><i class="fa-solid fa-money-bill-transfer"></i> Transfer</a>
        <a href="status.php" class="menu-item <?= $current_page == 'status.php' ? 'active' : '' ?>"><i class="fa-solid fa-wallet"></i></i> Topup</a>
        <a href="/logout.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <h1>Users Data</h1>
    <table>
        <thead>
            <tr>
                <th class="rounded-header-top-left">ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Address</th>
                <th class="rounded-header-top-right">Role</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['password'] ?></td>
                        <td><?= $user['address'] ?></td>
                        <td><?= $user['role'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data pengguna.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- script -->
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
