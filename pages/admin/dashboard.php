<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit;
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-soft-purple text-center">Dashboard Admin 🛠</h2>

    <div class="row g-4 justify-content-center">
        <!-- Box: Kelola Produk -->
        <div class="col-md-4">
            <a href="../../modules/products/index.php" class="text-decoration-none">
                <div class="card text-center shadow-sm" style="border-radius: 1rem; background-color: #fbefff;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #b36bff;">📦 Produk</h5>
                        <p class="card-text">Kelola data produk fashion</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Box: Kelola Kategori -->
        <div class="col-md-4">
            <a href="../../modules/categories/index.php" class="text-decoration-none">
                <div class="card text-center shadow-sm" style="border-radius: 1rem; background-color: #ffeefc;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #ff80ab;">🗂 Kategori</h5>
                        <p class="card-text">Kelola kategori produk</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Box: Kelola Supplier -->
        <div class="col-md-4">
            <a href="../../modules/suppliers/index.php" class="text-decoration-none">
                <div class="card text-center shadow-sm" style="border-radius: 1rem; background-color: #e0f7fa;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #00acc1;">🏭 Supplier</h5>
                        <p class="card-text">Kelola data supplier produk</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Box: Manajemen Pengguna -->
        <div class="col-md-4">
            <a href="../../modules/users/index.php" class="text-decoration-none">
                <div class="card text-center shadow-sm" style="border-radius: 1rem; background-color: #e8f0ff;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #7c8aff;">👥 Pengguna</h5>
                        <p class="card-text">Kelola akun admin, kasir, user</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Box: Laporan -->
        <div class="col-md-4">
            <a href="../../report/laporan_penjualan.php" class="text-decoration-none">
                <div class="card text-center shadow-sm" style="border-radius: 1rem; background-color: #fff5d6;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #ffb347;">📊 Laporan</h5>
                        <p class="card-text">Lihat dan cetak laporan penjualan</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
