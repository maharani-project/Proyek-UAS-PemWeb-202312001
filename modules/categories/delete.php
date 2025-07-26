<?php
include '../../config/db.php';
include '../../includes/auth.php';

// Pastikan hanya admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../pages/user/login.php");
    exit;
}

// Validasi dan amankan ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit;
?>
