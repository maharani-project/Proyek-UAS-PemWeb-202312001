<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../../pages/user/login.php");
    exit;
}

include '../../config/db.php';
include '../../includes/header.php';

$kasir_id = $_SESSION['user_id'];

$sql = "SELECT o.id AS order_id, o.*, c.name AS customer_name, u.username AS kasir_name 
        FROM orders o
        JOIN customers c ON o.customer_id = c.id
        JOIN users u ON o.kasir_id = u.id
        WHERE o.status = 'processed' AND o.kasir_id = ?
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Query error: " . $conn->error);
}
$stmt->bind_param("i", $kasir_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5">
    <h2 class="mb-4 text-soft-purple">📋 Riwayat Transaksi Saya</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">✅ Pesanan berhasil diproses!</div>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <?php
                            $order_id = $row['order_id'];
                            $total_result = mysqli_query($conn, "SELECT SUM(price * quantity) AS total FROM order_items WHERE order_id = $order_id");
                            $total_data = mysqli_fetch_assoc($total_result);
                            $total = $total_data['total'] ?? 0;
                            ?>
                            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                            <td>
                                <a href="detail.php?id=<?= $row['order_id'] ?>" class="btn btn-sm btn-info">Lihat</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php elseif (!isset($_GET['success'])): ?>
        <div class="alert alert-warning">Belum ada transaksi yang diproses oleh Anda.</div>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>
