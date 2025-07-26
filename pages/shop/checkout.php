<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$customer_query = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $user_id");
$customer = mysqli_fetch_assoc($customer_query);

if (isset($_POST['submit_customer'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    if ($customer) {
        mysqli_query($conn, "UPDATE customers SET name='$name', phone='$phone', address='$address' WHERE user_id=$user_id");
    } else {
        mysqli_query($conn, "INSERT INTO customers (user_id, name, phone, address) VALUES ($user_id, '$name', '$phone', '$address')");
    }

    header("Location: checkout.php");
    exit();
}

$order_items = [];
$grand_total = 0;
$order_data = [];

if (isset($_POST['checkout']) && $customer) {
    $cart = $_SESSION['cart'] ?? [];

    if (!empty($cart)) {
        $customer_id = $customer['id'];
        $order_date = date('Y-m-d H:i:s');
        $status = 'pending';

        mysqli_query($conn, "INSERT INTO orders (user_id, customer_id, order_date, status) 
                             VALUES ($user_id, $customer_id, '$order_date', '$status')");
        $order_id = mysqli_insert_id($conn);
        $_SESSION['last_order_id'] = $order_id;

        foreach ($cart as $product_id => $item) {
            $size = $item['size'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $product_name = mysqli_real_escape_string($conn, $item['name'] ?? 'Produk Tidak Diketahui');

            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, product_name, size, quantity, price) 
                                 VALUES ($order_id, $product_id, '$product_name', '$size', $quantity, $price)");

            $subtotal = $quantity * $price;
            $grand_total += $subtotal;

            $order_items[] = [
                'product_name' => $item['name'] ?? 'Produk Tidak Diketahui',
                'size' => $size,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal
            ];
        }

        $order_data = [
            'name' => $customer['name'],
            'phone' => $customer['phone'],
            'address' => $customer['address'],
            'order_date' => $order_date,
            'status' => $status
        ];

        unset($_SESSION['cart']);
    }
}
?>

<?php include '../../includes/header.php'; ?>
<style>
body {
    background: linear-gradient(135deg, #fce4ec, #e0cfff);
}

.container {
    max-width: 700px;
}

.card-checkout {
    background-color: #ffffff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

@media print {
    .no-print {
        display: none !important;
    }
}
</style>

<div class="container mt-5">
    <div class="card-checkout">
        <?php if (empty($order_data)): ?>
            <h3 class="mb-4 text-dark"><i class="bi bi-bag-check-fill"></i> Checkout</h3>

            <?php if (!$customer): ?>
                <p>Isi data diri terlebih dahulu:</p>
                <form method="post">
                    <input type="text" name="name" class="form-control mb-3" placeholder="Nama Lengkap" required>
                    <input type="text" name="phone" class="form-control mb-3" placeholder="No. HP" required>
                    <textarea name="address" class="form-control mb-3" placeholder="Alamat Lengkap" required></textarea>
                    <button type="submit" name="submit_customer" class="btn btn-primary w-100">💾 Simpan Data</button>
                </form>
            <?php else: ?>
                <h5 class="fw-semibold text-secondary mb-3">🧍‍♀️ Data Diri</h5>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item bg-transparent border-0"><strong>Nama:</strong> <?= htmlspecialchars($customer['name']) ?></li>
                    <li class="list-group-item bg-transparent border-0"><strong>Telepon:</strong> <?= htmlspecialchars($customer['phone']) ?></li>
                    <li class="list-group-item bg-transparent border-0"><strong>Alamat:</strong> <?= htmlspecialchars($customer['address']) ?></li>
                </ul>

                <form method="post">
                    <button type="submit" name="checkout" class="btn btn-success w-100 py-2">
                        🛒 Konfirmasi & Checkout
                    </button>
                </form>
            <?php endif; ?>

        <?php else: ?>
            <h3 class="text-dark"><i class="bi bi-receipt"></i> Struk Pesanan</h3>
            <hr>
            <p><strong>Nama:</strong> <?= htmlspecialchars($order_data['name']) ?></p>
            <p><strong>No. HP:</strong> <?= htmlspecialchars($order_data['phone']) ?></p>
            <p><strong>Alamat:</strong> <?= htmlspecialchars($order_data['address']) ?></p>
            <p><strong>Tanggal Pesan:</strong> <?= date('d M Y H:i', strtotime($order_data['order_date'])) ?></p>
            <p><strong>Status:</strong> <?= ucfirst($order_data['status']) ?></p>

            <h5 class="mt-4">Daftar Produk:</h5>
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Ukuran</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= $item['size'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="fw-bold">
                        <td colspan="4">Total Bayar</td>
                        <td>Rp<?= number_format($grand_total, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4 no-print text-end">
                <button onclick="window.print()" class="btn btn-outline-primary">
                    🖨️ Cetak Struk
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
