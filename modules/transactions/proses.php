<?php
include '../../config/db.php';
session_start();

if ($_SESSION['role'] !== 'kasir') {
    header('Location: ../../pages/user/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $kasir_id = $_SESSION['user_id']; // Ambil ID kasir dari session

    $update = mysqli_query($conn, "UPDATE orders SET status = 'processed', kasir_id = '$kasir_id' WHERE id = '$order_id'");

    if ($update) {
        header("Location: index.php?msg=Pesanan berhasil diproses");
    } else {
        echo "Gagal mengupdate pesanan.";
    }
}
?>
