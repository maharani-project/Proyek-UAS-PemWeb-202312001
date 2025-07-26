<?php
session_start();
include '../../config/db.php';
include '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data pelanggan dari tabel `customers`
$query = "SELECT * FROM customers WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Jika belum ada data diri, arahkan isi dulu
if (!$customer) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Kamu belum mengisi data diri. Silakan lakukan checkout terlebih dahulu agar data tersimpan.</div></div>";
    include '../../includes/footer.php';
    exit;
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update = "UPDATE customers SET name=?, phone=?, address=? WHERE user_id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssi", $name, $phone, $address, $user_id);
    $stmt->execute();

    echo "<script>alert('Data diri berhasil diperbarui!'); window.location.href='profil.php';</script>";
    exit;
}
?>

<div class="container mt-5">
    <h3 class="text-center mb-4 text-soft-purple">👤 Profil Pelanggan</h3>
    <form method="POST" class="col-md-6 mx-auto p-4 shadow-sm rounded" style="background-color: #fef3f7;">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($customer['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" name="phone" id="phone" value="<?= htmlspecialchars($customer['phone']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Alamat Lengkap</label>
            <textarea class="form-control" name="address" id="address" rows="3" required><?= htmlspecialchars($customer['address']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100" style="background-color:#ec407a; border:none;">💾 Simpan Perubahan</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
