<?php
include '../../config/db.php';
session_start();

// Simulasi data
$user_id = 3;        // ID user role 'user'
$customer_id = 2;    // ID dari tabel customers
$kasir_id = 5;       // ID user role 'kasir' yang sedang login

$total_amount = 150000;
$status = 'proses';
$order_date = date('Y-m-d H:i:s');

// Simpan ke tabel orders
$query_order = "INSERT INTO orders (user_id, customer_id, kasir_id, total_amount, status, order_date) 
                VALUES ($user_id, $customer_id, $kasir_id, $total_amount, '$status', '$order_date')";

if (mysqli_query($conn, $query_order)) {
    $order_id = mysqli_insert_id($conn);

    // Simpan ke order_items
    $product_id = 1;
    $quantity = 2;
    $price = 75000;

    $query_item = "INSERT INTO order_items (order_id, product_id, quantity, price)
                   VALUES ($order_id, $product_id, $quantity, $price)";
    mysqli_query($conn, $query_item);

    echo "✅ Dummy order berhasil dibuat dengan ID: $order_id";
} else {
    echo "❌ Gagal membuat dummy order: " . mysqli_error($conn);
}
?>
