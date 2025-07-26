<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

// Ambil semua user dari database
$query = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<div class="container mt-5">
    <h3 class="mb-3 text-soft-purple">Manajemen Pengguna</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Pengguna</a>
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $query->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pengguna ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
