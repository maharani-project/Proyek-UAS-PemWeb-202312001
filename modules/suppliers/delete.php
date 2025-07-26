<?php
include '../../config/db.php';
include '../../includes/auth.php';

$id = $_GET['id'] ?? 0;

// Gunakan prepared statement untuk keamanan
$stmt = $conn->prepare("DELETE FROM suppliers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>
