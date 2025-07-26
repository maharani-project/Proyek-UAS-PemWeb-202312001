<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

// Ambil data supplier
$query = $conn->query("SELECT * FROM suppliers ORDER BY id DESC");
?>

<div class="container mt-5">
    <h3 class="mb-3 text-soft-purple">Manajemen Supplier</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Supplier</a>
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>Kontak</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $query->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['contact']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus supplier ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
