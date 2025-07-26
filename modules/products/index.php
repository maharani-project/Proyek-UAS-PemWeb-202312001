<?php
session_start();
require '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../pages/user/login.php");
    exit;
}

// Ambil data produk
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-soft-purple">Manajemen Produk</h2>

    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Produk</a>

    <div class="table-responsive">
        <table class="table table-bordered bg-white shadow-sm table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $i => $produk): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($produk['name']) ?></td>
                            <td>Rp <?= number_format($produk['price'], 0, ',', '.') ?></td>
                            <td><?= $produk['stock'] ?></td>
                            <td>
                                <a href="edit.php?id=<?= $produk['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="hapus.php?id=<?= $produk['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">Belum ada produk.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
