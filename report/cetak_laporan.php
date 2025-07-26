<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/user/login.php");
    exit;
}

include '../config/db.php';

// Ambil data semua laporan penjualan
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Laporan Penjualan</h2>
    <p>Dicetak pada: <?= date('d-m-Y H:i') ?></p>
</div>

<?php if (!$result): ?>
    <p>Gagal mengambil data: <?= $conn->error ?></p>
<?php elseif ($result->num_rows === 0): ?>
    <p>Tidak ada data transaksi.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Total (Rp)</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grandTotal = 0;
            while ($row = $result->fetch_assoc()):
                $grandTotal += $row['total'];
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td class="text-right"><?= number_format($row['total'], 0, ',', '.') ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['order_date'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Total Keseluruhan</th>
                <th class="text-right"><?= number_format($grandTotal, 0, ',', '.') ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
<?php endif; ?>

<div class="footer no-print">
    <button onclick="window.print()">🖨️ Cetak Sekarang</button>
    <button onclick="window.location.href='laporan_penjualan.php'">← Kembali</button>
</div>

</body>
</html>
