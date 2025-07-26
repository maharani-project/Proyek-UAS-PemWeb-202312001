<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../../pages/user/login.php");
    exit;
}

include '../../config/db.php';
include '../../includes/header.php';

if (isset($_GET['proses'])) {
    $order_id = (int)$_GET['proses'];
    $conn->query("UPDATE orders SET status = 'diproses' WHERE id = $order_id");
    header("Location: konfirmasi.php");
    exit;
}

$orders = $conn->query("SELECT * FROM orders WHERE status = 'pending' ORDER BY created_at DESC");
?>

<div class="container mt-5">
    <h3 class="text-soft-purple mb-4">📝 Konfirmasi Transaksi Pelanggan</h3>

    <?php if ($orders->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Total</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td>Rp<?= number_format($row['total_amount'], 0, ',', '.') ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <a href="?proses=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Proses</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Belum ada transaksi yang menunggu konfirmasi.</div>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>
