<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../../pages/user/login.php");
    exit;
}
include '../../config/db.php';

// Ambil pesanan yang masih pending
$query = "SELECT o.id, c.name AS customer_name, o.total_price, o.status
          FROM orders o
          JOIN customers c ON o.customer_id = c.id
          WHERE o.status = 'pending'
          ORDER BY o.id DESC";
$result = $conn->query($query);
?>

<?php include '../../includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">🧾 Daftar Pesanan Masuk</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td>Rp<?= number_format($row['total_price']) ?></td>
                    <td><span class="badge bg-warning text-dark"><?= $row['status'] ?></span></td>
                    <td>
                        <form action="proses.php" method="POST" onsubmit="return confirm('Yakin proses pesanan ini?')">
                            <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-success btn-sm">Proses</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Belum ada pesanan yang masuk.</div>
    <?php endif; ?>
</div>
<?php include '../../includes/footer.php'; ?>
