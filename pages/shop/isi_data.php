<?php
session_start();
require '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Cek apakah data sudah ada
$stmt = $conn->prepare("SELECT * FROM customers WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Sudah isi data → langsung ke checkout
    header("Location: checkout.php");
    exit;
}

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if ($name && $phone && $address) {
        $stmt = $conn->prepare("INSERT INTO customers (user_id, name, phone, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $name, $phone, $address);
        $stmt->execute();

        header("Location: checkout.php");
        exit;
    } else {
        $error = "Semua data wajib diisi.";
    }
}
?>

<div class="container mt-5">
    <div class="card shadow p-4" style="max-width: 500px; margin: auto;">
        <h4 class="mb-4 text-center">📝 Lengkapi Data Diri Anda</h4>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>No. HP</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat Lengkap</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
            <button class="btn btn-primary w-100">Simpan & Lanjut Checkout</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
