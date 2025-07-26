<?php
session_start();
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $size = $_POST['size'] ?? '';
    $quantity = intval($_POST['quantity']) ?: 1;

    $stmt = $conn->prepare("SELECT p.*, c.name AS category_name FROM products p 
                            LEFT JOIN categories c ON p.category_id = c.id
                            WHERE p.id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product && $size) {
        $item = [
            'product_id'    => $product['id'],
            'name'          => $product['name'],
            'price'         => $product['price'],
            'quantity'      => $quantity,
            'image'         => $product['image'],
            'category_id'   => $product['category_id'],
            'category_name' => $product['category_name'],
            'size'          => $size
        ];

        $_SESSION['cart'][] = $item;
    }
}

header("Location: pages/shop/keranjang.php");
exit;
