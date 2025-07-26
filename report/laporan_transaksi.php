<?php
require '../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include '../../config/db.php';

$sql = "SELECT o.*, c.name AS customer_name 
        FROM orders o
        JOIN customers c ON o.customer_id = c.id
        ORDER BY o.created_at DESC";
$result = mysqli_query($conn, $sql);

ob_start();
?>

<h2>Laporan Transaksi</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['customer_name'] ?></td>
            <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
            <td><?= number_format($row['total_price']) ?></td>
            <td><?= ucfirst($row['status']) ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$html = ob_get_clean();
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("laporan-transaksi.pdf", ["Attachment" => false]);
exit;
?>
