<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM suppliers WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $conn->query("UPDATE suppliers SET name='$name', contact='$contact', address='$address' WHERE id=$id");
    header("Location: index.php");
}
?>

<div class="container mt-5">
    <h3 class="mb-3 text-soft-purple">Edit Supplier</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="<?= $data['name'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Kontak</label>
            <input type="text" name="contact" class="form-control" value="<?= $data['contact'] ?>">
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control"><?= $data['address'] ?></textarea>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
