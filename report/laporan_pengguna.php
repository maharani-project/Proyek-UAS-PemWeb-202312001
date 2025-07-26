<?php
require_once '../config/db.php';
require_once '../includes/auth.php';

$query = $pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC");
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h4 class="mb-4 text-primary">Laporan Pengguna</h4>
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Terdaftar Sejak</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= ucfirst($row['role']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
