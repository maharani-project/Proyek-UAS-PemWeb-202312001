<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../pages/user/login.php");
    exit;
}

$query = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<div class="container mt-5">
    <h3 class="mb-3 text-soft-purple">Manajemen Kategori</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Kategori</a>
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($query->num_rows > 0): ?>
                <?php while($row = $query->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center">Belum ada kategori.</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
