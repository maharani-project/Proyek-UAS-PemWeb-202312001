<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../pages/user/login.php");
    exit;
}

$query = $conn->query("
    SELECT o.id, c.name as customer_name, o.order_date, o.total, o.status
    FROM orders o
    JOIN customers c ON o.customer_id = c.id
    ORDER BY o.order_date DESC
");
?>

<div class="container mt-5">
    <h3 class="mb-4 text-soft-purple">Laporan Transaksi Penjualan</h3>
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>ID Pesanan</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $query->fetch_assoc()) : ?>
            <tr>
                <td>#<?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td><?= date('d-m-Y H:i', strtotime($row['order_date'])) ?></td>
                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['status']) ?></span></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
