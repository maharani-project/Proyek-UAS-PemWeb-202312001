<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit;
}

include '../config/db.php';
include '../includes/header.php';

if (!isset($_GET['id'])) {
    echo "<div class='container mt-5 alert alert-danger'>ID pesanan tidak ditemukan.</div>";
    include '../includes/footer.php';
    exit;
}

$order_id = $_GET['id'];

// Ambil data pesanan dan pelanggan
$stmt = $conn->prepare("SELECT o.*, c.name AS customer_name, c.phone, c.address 
                        FROM orders o 
                        JOIN customers c ON o.customer_id = c.id
                        WHERE o.id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    echo "<div class='container mt-5 alert alert-danger'>Data pesanan tidak ditemukan.</div>";
    include '../includes/footer.php';
    exit;
}

$order = $order_result->fetch_assoc();

// Ambil item pesanan (pakai LEFT JOIN agar produk yang sudah dihapus tetap bisa ditampilkan)
$item_stmt = $conn->prepare("SELECT oi.*, oi.product_name, (oi.price * oi.quantity) AS subtotal
                             FROM order_items oi 
                             WHERE oi.order_id = ?");

$item_stmt->bind_param("i", $order_id);
$item_stmt->execute();
$items_result = $item_stmt->get_result();
?>

<div class="container mt-5 mb-5">
    <h2 class="text-soft-purple">🧾 Struk Pesanan (Admin)</h2>
    <hr>
    <p><strong>ID Pesanan:</strong> <?= $order['id'] ?></p>
    <p><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></p>
    <p><strong>Pelanggan:</strong> <?= htmlspecialchars($order['customer_name']) ?> | <?= htmlspecialchars($order['phone']) ?></p>
    <p><strong>Alamat:</strong> <?= htmlspecialchars($order['address']) ?></p>

    <table class="table table-bordered mt-4">
        <style>
@media print {
    .no-print {
        display: none !important;
    }
}
</style>

        <thead class="table-light">
            <tr>
                <th>Produk</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($items_result->num_rows === 0): ?>
                <tr>
                    <td colspan="5" class="text-center text-danger">Tidak ada item dalam pesanan ini.</td>
                </tr>
            <?php else: ?>
                <?php
                $total = 0;
                while ($item = $items_result->fetch_assoc()):
                    $subtotal = $item['subtotal'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= htmlspecialchars($item['size']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                    <td>Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
                <?php endwhile; ?>
                <tr class="table-warning">
                    <th colspan="4" class="text-end">Total</th>
                    <th>Rp<?= number_format($total, 0, ',', '.') ?></th>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

<div class="text-end mt-4 no-print">
    <a href="javascript:window.print()" class="btn btn-primary">🖨️ Cetak Struk</a>

    <?php if ($_SESSION['role'] !== 'admin'): ?>
        <a href="../pages/kasir/dashboard.php" class="btn btn-secondary">Kembali</a>
    <?php endif; ?>
</div>

</div>

<?php include '../includes/footer.php'; ?>
