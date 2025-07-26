<?php
include '../../config/db.php';
include '../../includes/auth.php';
include '../../includes/header.php';

$id = $_GET['id'] ?? 0;

// Ambil data produk
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

// Ambil kategori & supplier
$categories = $conn->query("SELECT * FROM categories");
$suppliers  = $conn->query("SELECT * FROM suppliers");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $desc  = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $cat   = $_POST['category_id'];
    $sup   = $_POST['supplier_id'];

    if ($_FILES['image']['name']) {
        $imageName = $_FILES['image']['name'];
        $tmpImage  = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmpImage, "../../uploads/" . $imageName);

        // Update dengan gambar
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, stock=?, image=?, category_id=?, supplier_id=? WHERE id=?");
        $stmt->bind_param("ssdisiii", $name, $desc, $price, $stock, $imageName, $cat, $sup, $id);
    } else {
        // Update tanpa ubah gambar
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, stock=?, category_id=?, supplier_id=? WHERE id=?");
        $stmt->bind_param("ssdisii", $name, $desc, $price, $stock, $cat, $sup, $id);
    }

    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>

<div class="container mt-5">
    <h3 class="mb-3 text-soft-purple">Edit Produk</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_id" class="form-control">
                <?php while($c = $categories->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>" <?= $product['category_id'] == $c['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control">
                <?php while($s = $suppliers->fetch_assoc()): ?>
                    <option value="<?= $s['id'] ?>" <?= $product['supplier_id'] == $s['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Gambar Baru (opsional)</label>
            <input type="file" name="image" class="form-control">
            <small>Gambar saat ini: <strong><?= htmlspecialchars($product['image']) ?></strong></small>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
