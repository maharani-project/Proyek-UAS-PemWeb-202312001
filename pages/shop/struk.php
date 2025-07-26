<?php
session_start();
include '../../config/db.php';
include '../../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID pesanan tidak ditemukan.</div>";
    include '../../includes/footer.php';
    exit;
}

$order_id = intval($_GET['id']); // pastikan integer

// Ambil detail pesanan
$sql_order = "SELECT o.*, c.name AS customer_name, c.phone, c.address
              FROM orders o
              JOIN customers c ON o.customer_id = c.id
              WHERE o.id = $order_id AND o.user_id = {$_SESSION['user_id']}";

$result_order = mysqli_query($conn, $sql_order);
if (!$result_order || mysqli_num_rows($result_order) == 0) {
    echo "<div class='alert alert-warning'>Pesanan tidak ditemukan.</div>";
    include '../../includes/footer.php';
    exit;
}

$order = mysqli_fetch_assoc($result_order);

// Ambil item-item dalam pesanan
$sql_items = "SELECT oi.product_name, oi.size, oi.quantity, oi.price, (oi.price * oi.quantity) AS subtotal
              FROM order_items oi
              WHERE oi.order_id = $order_id";

$result_items = mysqli_query($conn, $sql_items);

?>

<style>
@media print {
    .no-print {
        display: none;
    }
}
</style>

<div class="container mt-4">
    <h3 class="text-soft-purple">🧾 Struk Pesanan</h3>
    
    <hr>
    <p><strong>Nama:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
    <p><strong>HP:</strong> <?= htmlspecialchars($order['phone']) ?></p>
    <p><strong>Alamat:</strong> <?= htmlspecialchars($order['address']) ?></p>
    <p><strong>Tanggal:</strong> <?= $order['created_at'] ?></p>

    <div class="table-responsive mt-3">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Produk</th>
                    <th>Ukuran</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total = 0;
                while ($item = mysqli_fetch_assoc($result_items)) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= htmlspecialchars($item['size']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rp<?= number_format($item['price']) ?></td>
                        <td>Rp<?= number_format($subtotal) ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr class="table-secondary">
                    <td colspan="5" class="text-end"><strong>Total</strong></td>
                    <td><strong>Rp<?= number_format($total) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="text-center no-print mt-4">
    <a href="#" onclick="window.print();" class="btn btn-primary">
        🖨️ Cetak Struk
    </a>
</div>
<?php include '../../includes/footer.php'; ?>
