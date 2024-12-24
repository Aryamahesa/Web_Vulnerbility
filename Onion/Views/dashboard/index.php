<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../config/connect.php';

// Check if user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /login.php');
    exit;
}

// Query to get the total counts
$query = "
    SELECT 
        (SELECT COUNT(*) FROM topup) AS total_topups,
        (SELECT COUNT(*) FROM transfer) AS total_transfers,
        (SELECT COUNT(*) FROM topup WHERE status = 'approved') AS approved_topups,
        (SELECT COUNT(*) FROM topup WHERE status = 'rejected') AS rejected_topups,
        (SELECT COUNT(*) FROM users) AS total_users;
";

$result = $conn->query($query);
$data = $result->fetch_assoc(); // Fetch the result into an associative array

$current_page = basename($_SERVER['PHP_SELF']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/../../public/css/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<!-- Sidebar Menu -->
<div class="sidebar">
<div class="sidebar-header">
        <img src="../../public/img/onion-logo.png" alt="Logo" class="logo">
    </div>
    <ul class="sidebar-menu">
        <a href="#" class="menu-item <?= $current_page == 'index.php' ? 'active' : '' ?>"><i class="fas fa-fw fa-tachometer-alt"></i> Dashboard</a>
        <a href="users.php" class="menu-item <?= $current_page == 'users.php' ? 'active' : '' ?>"><i class="fas fa-users"></i> Users</a>
        <a href="chat.php" class="menu-item <?= $current_page == 'chat.php' ? 'active' : '' ?>"><i class="fas fa-comment-alt"></i></i> Chat</a>
        <a href="transfer.php" class="menu-item <?= $current_page == 'transfer.php' ? 'active' : '' ?>"><i class="fa-solid fa-money-bill-transfer"></i> Transfer</a>
        <a href="status.php" class="menu-item <?= $current_page == 'status.php' ? 'active' : '' ?>"><i class="fa-solid fa-wallet"></i></i> Topup</a>
        <a href="/logout.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </ul>
</div>

<div class="main-content">
    <div class="container">
        <div class="dashboard">
            <div class="card blue">
                <h2>Total Top Up</h2>
                <p><?= $data['total_topups'] ?></p>
                <i class="fas fa-wallet"></i>
                <a href="topup.html" class="more-info">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card green">
                <h2>Total Transfer</h2>
                <p><?= $data['total_transfers'] ?></p>
                <i class="fas fa-exchange-alt"></i>
                <a href="transfer.html" class="more-info">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card yellow">
                <h2>Total Approve</h2>
                <p><?= $data['approved_topups']?></p>
                <i class="fas fa-check-circle"></i>
                <a href="approve.html" class="more-info">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card red">
                <h2>Total Reject</h2>
                <p><?= $data['rejected_topups']?></p>
                <i class="fas fa-times-circle"></i>
                <a href="reject.html" class="more-info">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card purple">
                <h2>Total Users</h2>
                <p><?= $data['total_users'] ?></p>
                <i class="fas fa-users"></i>
                <a href="users.html" class="more-info">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- script -->
<script>
    // Add event listener for all menu items
    const menuItems = document.querySelectorAll('.menu-item');

    menuItems.forEach(item => {
        item.addEventListener('click', function () {
            // Remove active class from all menu items
            menuItems.forEach(menu => menu.classList.remove('active'));

            // Add active class to clicked menu
            this.classList.add('active');
        });
    });
</script>
</body>
</html>
