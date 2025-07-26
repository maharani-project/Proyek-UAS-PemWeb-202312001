<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../user/login.php");
    exit;
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-soft-purple text-center">Dashboard Kasir 💼</h2>

    <div class="row g-4 justify-content-center">
        <!-- Box: Transaksi Baru -->
        <div class="col-md-4">
            <a href="../../modules/transactions/pending.php" class="text-decoration-none">
                <div class="card text-center shadow-sm" style="border-radius: 1rem; background-color: #e0f7fa;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #00acc1;">🛒 Transaksi Baru</h5>
                        <p class="card-text">Lihat pesanan pelanggan yang menunggu</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Box: Riwayat Transaksi -->
        <div class="col-md-4">
            <a href="../../modules/transactions/index.php" class="text-decoration-none">
                <div class="card text-center shadow-sm" style="border-radius: 1rem; background-color: #f3e5f5;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #ab47bc;">🧾 Riwayat Transaksi</h5>
                        <p class="card-text">Lihat daftar transaksi sebelumnya</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
