<?php
session_start();

if (isset($_POST['hapus']) && is_array($_POST['hapus'])) {
    foreach ($_POST['hapus'] as $index) {
        if (isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
        }
    }
    // Reset indeks array supaya rapi
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// Tambahan: hapus item via GET (jika ada)
if (isset($_GET['index']) && isset($_SESSION['cart'][$_GET['index']])) {
    unset($_SESSION['cart'][$_GET['index']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header("Location: keranjang.php");
exit;
