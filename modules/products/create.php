<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

// Ambil kategori & supplier
$categories = $conn->query("SELECT * FROM categories");
$suppliers = $conn->query("SELECT * FROM suppliers");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $desc  = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $cat   = $_POST['category_id'];
    $sup   = $_POST['supplier_id'];

    $imageName = $_FILES['image']['name'];
    $tmpImage  = $_FILES['image']['tmp_name'];

    // Upload file
    $targetDir = "../../uploads/";
    $targetPath = $targetDir . basename($imageName);
    move_uploaded_file($tmpImage, $targetPath);

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image, category_id, supplier_id) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdisii", $name, $desc, $price, $stock, $imageName, $cat, $sup);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<div class="container mt-5">
    <h3 class="mb-4 text-soft-purple">Tambah Produk</h3>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_id" class="form-control" required>
                <?php while($c = $categories->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control" required>
                <?php while($s = $suppliers->fetch_assoc()): ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Gambar Produk</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
