<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "
    SELECT o.id, o.order_date, o.status, c.name 
    FROM orders o
    JOIN customers c ON o.customer_id = c.id
    WHERE o.user_id = $user_id
    ORDER BY o.order_date DESC
");
?>

<?php include '../../includes/header.php'; ?>
<div class="container mt-5">
    <h3>Riwayat Pesanan</h3>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= date('d M Y H:i', strtotime($row['order_date'])) ?></td>
                <td><span class="badge bg-secondary"><?= $row['status'] ?></span></td>
                <td><a href="struk.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Lihat Struk</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../../includes/footer.php'; ?>
