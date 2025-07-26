<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../pages/user/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    // Validasi sederhana
    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();

        header("Location: index.php");
        exit;
    }
}
?>

<div class="container mt-5">
    <h3 class="mb-3 text-soft-purple">Tambah Kategori</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
