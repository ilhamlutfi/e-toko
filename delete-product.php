<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika tidak login, redirect ke halaman login
    exit();
}

// Memanggil file ProductController.php
require_once 'app/ProductController.php';

// Membuat instance dari ProductController
$productController = new ProductController();

// Cek id
if (isset($_GET['id'])) {
    $productId = (int)$_GET['id']; // Mengambil ID dari URL

    // Menghapus produk
    $productController->delete($productId);
} else {
    echo "Error: No product ID provided.";
}
