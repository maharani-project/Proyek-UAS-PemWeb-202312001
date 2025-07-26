<?php
include '../../includes/auth.php';
include '../../includes/header.php';
require '../../config/db.php';

// Fungsi: map category_id ke nama folder
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

// Ambil keyword dari URL (GET) jika ada
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

// Jika ada keyword pencarian, cari berdasarkan nama produk
if ($keyword !== '') {
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? ORDER BY created_at DESC");
    $likeKeyword = "%" . $keyword . "%";
    $stmt->bind_param("s", $likeKeyword);
} else {
    // Jika tidak ada keyword, tampilkan semua produk
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC");
}

$stmt->execute();
$result = $stmt->get_result();
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
?>

<div class="container mt-4" style="background-color: #f8f9fa;">
    <form method="GET" action="index.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control rounded-start-4" placeholder="Cari produk..." value="<?= htmlspecialchars($keyword) ?>">
            <button class="btn btn-soft-pink rounded-end-4" type="submit">Cari</button>
        </div>
    </form>

    <h2 class="mb-4 text-soft-purple">Katalog Produk</h2>
    <div class="row g-3">
        <?php if (count($products) === 0): ?>
            <div class="col-12">
                <div class="alert alert-warning">Produk tidak ditemukan untuk kata kunci <strong><?= htmlspecialchars($keyword) ?></strong></div>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <?php
                    $folder = getCategoryFolder($product['category_id']);
                    $imagePath = "../../uploads/$folder/" . htmlspecialchars($product['image']);
                ?>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4" style="background-color: #fdf2f8;">
                        <img src="<?= $imagePath ?>" class="card-img-top rounded-top-4" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text text-muted">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
                            <a href="detail.php?id=<?= $product['id'] ?>" class="btn btn-soft-purple w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
