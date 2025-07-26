<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

$query = $conn->query("
    SELECT l.id, u.username, l.activity, l.log_time 
    FROM activity_logs l 
    JOIN users u ON l.user_id = u.id 
    ORDER BY l.log_time DESC
");
?>

<div class="container mt-5">
    <h3 class="mb-4 text-soft-purple">Log Aktivitas Pengguna</h3>
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Aktivitas</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $query->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['activity']) ?></td>
                <td><?= $row['log_time'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
