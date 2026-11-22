<?php
require_once __DIR__ . '/config/db.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($title ?? 'Pharmasia Ltd. B2B Ordering Portal') ?></title>
    <link rel="preconnect" href="https://images.unsplash.com">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
    <a href="index.php" class="brand">
        <span class="brand-mark">P</span>
        <span>Medical Store <em>Ltd.</em></span>
    </a>
    <button class="nav-toggle" aria-label="Menu">☰</button>
    <nav class="nav">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="admin/login.php">Admin</a>
        <a class="btn small" href="cart.php">Cart <?= cart_count() ?></a>
    </nav>
</header>