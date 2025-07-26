<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../pages/user/login.php");
    exit;
}

// Validasi ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data kategori
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "<div class='alert alert-danger'>Kategori tidak ditemukan.</div>";
    include '../../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if (!empty($name)) {
        $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();

        header("Location: index.php");
        exit;
    }
}
?>

<div class="container mt-5">
    <h3 class="mb-3 text-soft-purple">Edit Kategori</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
