<?php
include '../../config/db.php';
include '../../includes/auth.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

// Ambil nama file gambar dulu
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Hapus gambar jika ada
if ($product && !empty($product['image'])) {
    $image_path = "../../uploads/" . $product['image'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

// Hapus produk
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>
