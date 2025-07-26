<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MbetaRO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            background: linear-gradient(to bottom right, #fce3ec, #f9e0ff, #e0f0ff);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar {
            background: linear-gradient(to right, #f9e0ff, #ffd6e0, #e0f0ff);
        }
        footer {
            background-color: #fce3ec;
            padding: 1rem;
            font-size: 0.9rem;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="/assets/img/logo.png" alt="Logo MbetaRO">
            <span class="fw-bold text-dark">MbetaRO</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <?php if (isset($_SESSION['role'])): ?>
                    <li class="nav-item">
                        <span class="nav-link disabled text-muted">Halo, <?= ucfirst($_SESSION['role']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/pages/user/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/pages/user/login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pages/user/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
