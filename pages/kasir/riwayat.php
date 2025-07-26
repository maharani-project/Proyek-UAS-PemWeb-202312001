<?php
session_start();
include '../../config/db.php';
include '../../includes/header.php';

// Pastikan kasir sudah login
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../../pages/user/login.php");
    exit();
}

$kasir_id = $_SESSION['user_id'];
?>

<div class="container mt-5">
    <h2 class="mb-4 text-soft-purple">📋 Riwayat Transaksi Saya</h2>

    <?php
    $sql = "SELECT o.id, o.order_date, o.total_amount, c.name AS customer_name
            FROM orders o
            JOIN customers c ON o.customer_id = c.id
            WHERE o.status = 'processed' AND o.processed_by = ?
            ORDER BY o.order_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $kasir_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td><?= date('d M Y, H:i', strtotime($row['order_date'])) ?></td>
                        <td>Rp <?= number_format($row['total_amount'], 0, ',', '.') ?></td>
                        <td><a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Belum ada transaksi yang diproses oleh Anda.</div>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>
