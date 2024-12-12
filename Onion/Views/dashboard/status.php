<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include __DIR__ . '/../../config/connect.php';

$query_topup = "SELECT topup.*, users.username FROM topup JOIN users ON topup.user_id = users.id WHERE topup.status = 'pending'";
$query_transfer = "SELECT transfer.*, sender.username AS sender_username, receiver.username AS receiver_username 
                   FROM transfer 
                   JOIN users AS sender ON transfer.sender_id = sender.id 
                   JOIN users AS receiver ON transfer.receiver_id = receiver.id 
                   WHERE transfer.status = 'pending'";

$result_topup = $conn->query($query_topup);
$result_transfer = $conn->query($query_transfer);
include __DIR__ . "/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/../../public/css/admin.css">
</head>
<body>
    <div class="content">
        <div class="container">
            <!-- Tabel Topup Pending -->
            <h2>Permintaan Top-Up Pending</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_topup->num_rows > 0): ?>
                        <?php while ($topup = $result_topup->fetch_assoc()): ?>
                            <tr>
                                <td><?= $topup['id'] ?></td>
                                <td><?= $topup['username'] ?></td>
                                <td><?= $topup['amount'] ?></td>
                                <td><?= $topup['status'] ?></td>
                                <td>
                                    <a href="approve_topup.php?id=<?= $topup['id'] ?>&action=approve" class="approve">Approve</a> |
                                    <a href="approve_topup.php?id=<?= $topup['id'] ?>&action=reject" class="reject">Reject</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Tidak ada permintaan top-up yang pending.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        
            <!-- Tabel Transfer Pending -->
            <h2>Permintaan Transfer Pending</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
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
                                <td><?= $transfer['status'] ?></td>
                                <td>
                                    <a href="approve_transfer.php?id=<?= $transfer['id'] ?>&action=approve" class="approve">Approve</a> |
                                    <a href="approve_transfer.php?id=<?= $transfer['id'] ?>&action=reject" class="reject">Reject</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Tidak ada permintaan transfer yang pending.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>