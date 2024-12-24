<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../config/connect.php';

// Konfigurasi Pagination
$records_per_page = 10; // Jumlah data per halaman
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;


// Query untuk menghitung total data
$total_query = "SELECT COUNT(*) AS total FROM transfer";
$total_result = $conn->query($total_query);
$total_data = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_data / $records_per_page);

// Query untuk mengambil data transfer dengan limit dan offset
$query_transfer = "
    SELECT 
        transfer.id,
        sender.username AS sender_username,
        receiver.username AS receiver_username,
        transfer.amount,
        transfer.created_at
    FROM transfer
    JOIN users AS sender ON transfer.sender_id = sender.id
    JOIN users AS receiver ON transfer.receiver_id = receiver.id
    ORDER BY transfer.created_at DESC
    LIMIT $records_per_page OFFSET $offset
";

$result_transfer = $conn->query($query_transfer);

$current_page = basename($_SERVER['PHP_SELF']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer History</title>
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
        <a href="users.php" class="menu-item <?= $current_page == 'users.php' ? 'active' : '' ?>"><i class="fas fa-users"></i> Users</a>
        <a href="chat.php" class="menu-item <?= $current_page == 'chat.php' ? 'active' : '' ?>"><i class="fas fa-comment-alt"></i> Chat</a>
        <a href="transfer.php" class="menu-item <?= $current_page == 'transfer.php' ? 'active' : '' ?>"><i class="fa-solid fa-money-bill-transfer"></i> Transfer</a>
        <a href="status.php" class="menu-item <?= $current_page == 'status.php' ? 'active' : '' ?>"><i class="fa-solid fa-wallet"></i></i> Topup</a>
        <a href="/logout.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Tabel Riwayat Transfer -->
    <h1>Transfer History</h1>
    <table>
        <thead>
            <tr>
                <th class="rounded-header-top-left">ID</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Amount</th>
                <th class="rounded-header-top-right">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_transfer->num_rows > 0): ?>
                <?php while ($transfer = $result_transfer->fetch_assoc()): ?>
                    <tr>
                        <td><?= $transfer['id'] ?></td>
                        <td><?= $transfer['sender_username'] ?></td>
                        <td><?= $transfer['receiver_username'] ?></td>
                        <td><?= $transfer['amount'] ?></td>
                        <td><?= $transfer['created_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No transfer records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
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
