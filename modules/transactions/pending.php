<?php
session_start();
include '../../includes/header.php';
include '../../config/db.php';

// Cek role kasir
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../../pages/user/login.php");
    exit();
}

// Ambil data pesanan dengan status 'pending', JOIN ke customers
$query = "SELECT o.*, u.username, c.name, c.phone, c.address,
          (SELECT SUM(oi.quantity * oi.price) FROM order_items oi WHERE oi.order_id = o.id) AS total
          FROM orders o
          JOIN users u ON o.user_id = u.id
          JOIN customers c ON o.user_id = c.user_id
          WHERE o.status = 'pending' 
          ORDER BY o.created_at ASC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-soft-purple">Daftar Pesanan Masuk</h2>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['phone']); ?></td>
                            <td><?= htmlspecialchars($row['address']); ?></td>
                            <td>Rp<?= number_format($row['total'], 0, ',', '.'); ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="proses.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Proses</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Belum ada pesanan yang masuk.</div>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>
