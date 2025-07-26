<?php
session_start();
include '../../includes/auth.php';
include '../../includes/header.php';
require '../../config/db.php';

// Fungsi: map category_id ke folder gambar
function getCategoryFolder($category_id) {
    switch ($category_id) {
        case 1: return 'atasan_pria';
        case 2: return 'atasan_wanita';
        case 3: return 'bawahan_pria';
        case 4: return 'bawahan_wanita';
        case 5: return 'jaket';
        case 6: return 'sepatu';
        case 7: return 'tas';
        default: return 'lainnya';
    }
}

// Cek apakah ada ID produk di URL
if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$id = $_GET['id'];

// Ambil data produk
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Produk tidak ditemukan.";
    exit;
}

// Tentukan path gambar
$folder = getCategoryFolder($product['category_id']);
$imagePath = "../../uploads/$folder/" . htmlspecialchars($product['image']);

// Ambil ukuran tersedia dari tabel product_sizes
$sizeQuery = "SELECT size, stock FROM product_sizes WHERE product_id = ? AND stock > 0";
$sizeStmt = $conn->prepare($sizeQuery);
$sizeStmt->bind_param("i", $id);
$sizeStmt->execute();
$sizeResult = $sizeStmt->get_result();
?>

<div class="container mt-5">
    <div class="row g-5">
        <div class="col-md-6">
            <img src="<?= $imagePath ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="col-md-6">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <h4 class="text-muted">Rp<?= number_format($product['price'], 0, ',', '.') ?></h4>
            <p><?= htmlspecialchars($product['description']) ?></p>

            <form method="post" action="../../add_to_cart.php">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="product_name" value="<?= $product['name'] ?>">
                <input type="hidden" name="product_price" value="<?= $product['price'] ?>">
                <input type="hidden" name="product_image" value="<?= $product['image'] ?>">
                <input type="hidden" name="category_id" value="<?= $product['category_id'] ?>">

                <div class="mb-3">
                    <label for="size" class="form-label">Pilih Ukuran:</label>
                    <select name="size" id="size" class="form-select" required>
                        <?php while ($row = $sizeResult->fetch_assoc()) : ?>
                            <option value="<?= $row['size'] ?>"><?= $row['size'] ?> (Stok: <?= $row['stock'] ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Jumlah:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" style="width: 100px;" required>
                </div>

                <button type="submit" class="btn btn-primary rounded-pill px-4">🛒 Tambah ke Keranjang</button>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
