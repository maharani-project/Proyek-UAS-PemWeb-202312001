<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/user/login.php");
    exit;
}

include '../config/db.php';
include '../includes/header.php';

// ✅ Perbaikan hanya bagian query total
$query = "
    SELECT 
        o.id, 
        o.customer_id, 
        o.order_date, 
        c.name AS username,
        SUM(oi.quantity * oi.price) AS total
    FROM orders o 
    JOIN customers c ON o.customer_id = c.id 
    JOIN order_items oi ON o.id = oi.order_id
    GROUP BY o.id, o.customer_id, o.order_date, c.name
    ORDER BY o.order_date DESC
";
$result = $conn->query($query);
?>

<div class="container mt-5">
    <h3 class="text-center text-soft-purple mb-4">Laporan Penjualan 📊</h3>

    <!-- ✅ Tombol Cetak Semua Laporan -->
    <div class="mb-3 text-end">
        <a href="cetak_laporan.php" target="_blank" class="btn btn-success btn-sm">
            🖨️ Cetak Semua Laporan
        </a>
    </div>

    <?php if (!$result): ?>
        <div class="alert alert-danger">
            Terjadi kesalahan saat mengambil data: <?= $conn->error ?>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered bg-white shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Total (Rp)</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= number_format($row['total'], 0, ',', '.') ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($row['order_date'])) ?></td>
                                <td>
                                    <a href="struk_admin.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Lihat Struk</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">Belum ada transaksi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- ✅ Tombol Kembali diperbaiki -->
    <div class="mt-4 text-end">
        <a href="../pages/admin/dashboard.php" class="text-decoration-none" style="color: purple;">← Kembali</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
