<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../config/connect.php';

// Tentukan jumlah data per halaman
$limit = 10;

// Ambil nomor halaman dari URL (default halaman 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk mengambil semua riwayat top-up dengan pagination
$query_topup = "
    SELECT topup.*, users.username 
    FROM topup 
    JOIN users ON topup.user_id = users.id
    ORDER BY topup.created_at DESC
    LIMIT $limit OFFSET $offset
";
$result_topup = $conn->query($query_topup);

// Ambil total data untuk menghitung jumlah halaman
$query_count = "SELECT COUNT(*) AS total FROM topup";
$result_count = $conn->query($query_count);
$total_rows = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Menangani aksi approve atau reject
if (isset($_GET['action']) && isset($_GET['id'])) {
    $topup_id = (int)$_GET['id'];
    $action = $_GET['action'];

    // Validasi aksi (approve atau reject)
    if ($action === 'approve' || $action === 'reject') {
        $status = ($action === 'approve') ? 'approved' : 'rejected';

        // Update status top-up
        $update_query = "UPDATE topup SET status = '$status' WHERE id = $topup_id";
        if ($conn->query($update_query)) {
            echo "<script>alert('Top-up telah $status!'); window.location.href='status.php';</script>";
        } else {
            echo "Terjadi kesalahan saat memperbarui status top-up.";
        }
    }
}

$current_page = basename($_SERVER['PHP_SELF']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top-Up History</title>
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
        <a href="status.php" class="menu-item <?= $current_page == 'status.php' ? 'active' : '' ?>"><i class="fa-solid fa-wallet"></i> Top-Up</a>
        <a href="/logout.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">

    <!-- Tabel Riwayat Top-Up -->
    <h1>Top-Up History</h1>
    <table>
        <thead>
            <tr>
                <th class="rounded-header-top-left">ID</th>
                <th>Username</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Created At</th>
                <th class="rounded-header-top-right">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_topup->num_rows > 0): ?>
                <?php while ($topup = $result_topup->fetch_assoc()): ?>
                    <tr>
                        <td><?= $topup['id'] ?></td>
                        <td><?= $topup['username'] ?></td>
                        <td><?= $topup['amount'] ?></td>
                        <td><?= ucfirst($topup['status']) ?></td>
                        <td><?= $topup['created_at'] ?></td>
                        <td>
                            <?php if ($topup['status'] === 'pending'): ?>
                                <a href="?action=approve&id=<?= $topup['id'] ?>" class="approve">Approve</a> |
                                <a href="?action=reject&id=<?= $topup['id'] ?>" class="reject">Reject</a>
                            <?php else: ?>
                                <span>-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada riwayat top-up.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=1">&laquo; First</a>
            <a href="?page=<?= $page - 1 ?>">&lsaquo; Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>">Next &rsaquo;</a>
            <a href="?page=<?= $total_pages ?>">Last &raquo;</a>
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
