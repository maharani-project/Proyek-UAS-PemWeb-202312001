<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("INSERT INTO suppliers (name, contact, address) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $contact, $address);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<div class="container mt-5">
    <h3 class="mb-3 text-soft-purple">Tambah Supplier</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kontak</label>
            <input type="text" name="contact" class="form-control">
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control"></textarea>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
