<?php
include '../../config/db.php';
include '../../includes/auth.php';

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id=$id");

header("Location: index.php");
?>
