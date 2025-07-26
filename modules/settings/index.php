<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

// Simpan jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $value = $_POST['value'];

    // Gunakan prepared statement MySQLi
    $stmt = $conn->prepare("REPLACE INTO settings (name, value) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $value);
    $stmt->execute();

    $success = "Pengaturan berhasil disimpan.";
}

// Ambil semua pengaturan
$settings = [];
$result = $conn->query("SELECT * FROM settings");
while ($row = $result->fetch_assoc()) {
    $settings[$row['name']] = $row['value'];
}
?>

<div class="container mt-5">
    <h3 class="mb-4 text-soft-purple">Pengaturan Toko</h3>
    
    <?php if (!empty($success)) : ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Toko</label>
            <input type="hidden" name="name" value="nama_toko">
            <input type="text" name="value" class="form-control" value="<?= htmlspecialchars($settings['nama_toko'] ?? 'MbetaRO') ?>" required>
        </div>
        <button type="submit" class="btn btn-soft-purple">Simpan</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
