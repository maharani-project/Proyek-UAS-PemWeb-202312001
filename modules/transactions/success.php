<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../../pages/user/login.php");
    exit();
}

include '../../includes/header.php';
?>

<div class="container mt-5 text-center">
    <h2 class="text-success">✅ Pesanan berhasil diproses!</h2>
    <a href="pending.php" class="btn btn-primary mt-3">Kembali ke Daftar Pesanan</a>
</div>

<?php include '../../includes/footer.php'; ?>
