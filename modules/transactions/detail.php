<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../../pages/user/login.php");
    exit;
}

include '../../config/db.php';
include '../../includes/header.php';

if (!isset($_GET['id'])) {
    echo "<div class='container mt-5 alert alert-danger'>ID pesanan tidak ditemukan.</div>";
    include '../../includes/footer.php';
    exit;
}

$order_id = $_GET['id'];

// Ambil detail pesanan dan customer
$sql = "SELECT o.*, c.name AS customer_name, c.phone, c.address
        FROM orders o
        JOIN customers c ON o.customer_id = c.id
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "<div class='container mt-5 alert alert-warning'>Pesanan tidak ditemukan.</div>";
    include '../../includes/footer.php';
    exit;
}

// Ambil item pesanan langsung dari order_items tanpa JOIN
$sql_items = "SELECT * FROM order_items WHERE order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();
?>

<div class="container mt-5 print-area">
    <h2 class="mb-4 text-soft-purple">🧾 Detail Pesanan #<?= $order['id'] ?></h2>

    <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
    <p><strong>No. HP:</strong> <?= htmlspecialchars($order['phone']) ?></p>
    <p><strong>Alamat:</strong> <?= htmlspecialchars($order['address']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <p><strong>Tanggal:</strong> <?= date('d M Y, H:i', strtotime($order['order_date'])) ?></p>

    <h5 class="mt-4">📦 Daftar Produk:</h5>
    <table class="table table-bordered bg-white">
        <thead class="table-light">
            <tr>
                <th>Nama Produk</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grand_total = 0;
            while ($item = $result_items->fetch_assoc()):
                $subtotal = $item['price'] * $item['quantity'];
                $grand_total += $subtotal;
            ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= htmlspecialchars($item['size']) ?></td>
                    <td><?= (int)$item['quantity'] ?></td>
                    <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <p class="mt-3"><strong>Total Bayar:</strong> Rp <?= number_format($grand_total, 0, ',', '.') ?></p>
    <a href="#" onclick="window.print();" class="btn btn-primary mt-3">🖨️ Cetak Struk</a>


</div>
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .print-area, .print-area * {
        visibility: visible;
    }
    .print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    a, button, .btn, .logout, nav, header, footer {
        display: none !important;
    }
}
</style>


<?php include '../../includes/footer.php'; ?>
