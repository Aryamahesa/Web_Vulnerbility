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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/../../public/css/admin1.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

<!-- Sidebar Menu -->
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Dashboard</h2>
    </div>
    <ul class="sidebar-menu">
        <a href="admin.php"><i class="fas fa-users"></i> Users</a>
        <a href="status.php"><i class="fas fa-check-circle"></i> Status</a>
        <a href="/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <h2>Users Data</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Address</th>
                <th>Role</th>
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

</body>
</html>
