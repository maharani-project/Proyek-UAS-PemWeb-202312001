<?php
session_start();
include '../../includes/header.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_harga = 0;
?>

<div class="container mt-5">
    <h2 class="mb-4 text-soft-purple">🛒 Keranjang Belanja</h2>

    <?php if (empty($cart)): ?>
        <div class="alert alert-info">Keranjang belanja Anda kosong.</div>
    <?php else: ?>
        <form action="hapus_keranjang.php" method="post">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Produk</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $index => $item): ?>
                        <?php
                            // Mapping kategori ke folder
                            switch ($item['category_id']) {
                                case 1: $folder = 'atasan_pria'; break;
                                case 2: $folder = 'atasan_wanita'; break;
                                case 3: $folder = 'bawahan_pria'; break;
                                case 4: $folder = 'bawahan_wanita'; break;
                                case 5: $folder = 'jaket'; break;
                                case 6: $folder = 'sepatu'; break;
                                case 7: $folder = 'tas'; break;
                                default: $folder = 'lainnya'; break;
                            }

                            $gambar = "../../uploads/{$folder}/" . $item['image'];
                            $total = $item['price'] * $item['quantity'];
                            $total_harga += $total;
                        ?>
                        <tr>
                            <td><input type="checkbox" name="hapus[]" value="<?= $index ?>"></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= $gambar ?>" alt="<?= $item['name'] ?>" width="80" height="80" class="rounded me-2" onerror="this.src='../../assets/noimage.png'">
                                    <div>
                                        <strong><?= $item['name'] ?></strong><br>
                                        <small class="text-muted">Kategori: <?= $folder ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($item['size']) ?></td>
                            <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>Rp<?= number_format($total, 0, ',', '.') ?></td>
                            <td>
                                <button type="submit" name="hapus[]" value="<?= $index ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item ini?')">🗑️ Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total Harga:</th>
                        <th colspan="2">Rp<?= number_format($total_harga, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-outline-danger">🗑️ Hapus yang Dipilih</button>
                <a href="checkout.php" class="btn btn-success px-4 py-2">Lanjut ke Checkout</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
// Auto check/uncheck semua checkbox
document.getElementById('checkAll')?.addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('input[name="hapus[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
});
</script>

<?php include '../../includes/footer.php'; ?>
