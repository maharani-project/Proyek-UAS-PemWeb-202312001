<?php
session_start();

// Jika sudah login, arahkan berdasarkan role
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            header("Location: pages/admin/dashboard.php");
            break;
        case 'kasir':
            header("Location: pages/kasir/dashboard.php");
            break;
        case 'user':
            header("Location: pages/user/dashboard.php");
            break;
        default:
            session_destroy();
            header("Location: pages/user/login.php");
            break;
    }
    exit;
}

// Jika belum login, tampilkan katalog (misalnya)
header("Location: pages/shop/index.php");
exit;
