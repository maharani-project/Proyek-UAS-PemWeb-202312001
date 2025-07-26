<?php
require '../../vendor/autoload.php';
require '../../config/db.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['id'])) {
    die("ID pesanan tidak ditemukan.");
}

$order_id = (int)$_GET['id'];

// Ambil data order dan customer
$stmt = $conn->prepare("SELECT o.*, c.name, c.phone, c.address 
                        FROM orders o 
                        JOIN customers c ON o.customer_id = c.id 
                        WHERE o.id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    die("Pesanan tidak ditemukan.");
}

// Ambil item pesanan
$stmt_items = $conn->prepare("SELECT oi.*, p.name as product_name, p.price 
                              FROM order_items oi 
                              JOIN products p ON oi.product_id = p.id 
                              WHERE oi.order_id = ?");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items = $stmt_items->get_result();
$stmt_items->close();

ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Struk Pesanan #<?= htmlspecialchars($order['id']) ?></h2>
    <p><strong>Nama:</strong> <?= htmlspecialchars($order['name']) ?></p>
    <p><strong>HP:</strong> <?= htmlspecialchars($order['phone']) ?></p>
    <p><strong>Alamat:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
    <p><strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($order['order_date'])) ?></p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $items->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                <td><?= (int)$item['quantity'] ?></td>
                <td>Rp<?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h4 class="text-right">Total: Rp<?= number_format($order['total'], 0, ',', '.') ?></h4>
</body>
</html>

<?php
$html = ob_get_clean();

// Setup Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("struk_pesanan_{$order['id']}.pdf", ["Attachment" => false]);
exit;
?>
