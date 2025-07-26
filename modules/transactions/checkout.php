<?php
session_start();
include_once '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../../pages/user/login.php");
    exit();
}

// Jika keranjang kosong
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang kamu kosong!'); window.location.href='../../pages/shop/index.php';</script>";
    exit();
}

// Ambil data user dari session
$user_id = $_SESSION['user_id'];

// Ambil total belanja
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['qty'] * $item['price'];
}

// Simpan ke tabel orders
$queryOrder = "INSERT INTO orders (user_id, total_amount, status, order_date) VALUES (?, ?, 'pending', NOW())";
$stmtOrder = $conn->prepare($queryOrder);
$stmtOrder->bind_param("id", $user_id, $total);
$stmtOrder->execute();
$order_id = $stmtOrder->insert_id;

// Simpan ke tabel order_items
$queryItem = "INSERT INTO order_items (order_id, product_id, quantity, subtotal, size) VALUES (?, ?, ?, ?, ?)";
$stmtItem = $conn->prepare($queryItem);

foreach ($_SESSION['cart'] as $item) {
    $subtotal = $item['qty'] * $item['price'];
    $stmtItem->bind_param("iiids", $order_id, $item['product_id'], $item['qty'], $subtotal, $item['size']);
    $stmtItem->execute();
}

// Bersihkan keranjang
unset($_SESSION['cart']);

echo "<script>alert('Checkout berhasil! Pesananmu sedang diproses.'); window.location.href='../../pages/shop/riwayat.php';</script>";
exit();
?>
