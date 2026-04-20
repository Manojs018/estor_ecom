<?php

require_once __DIR__ . '/../app/functions.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/admin_products.php');
}

$productId = (int) ($_POST['id'] ?? 0);

if ($productId <= 0) {
    setFlash('error', 'Invalid product delete request.');
    redirect('/admin_products.php');
}

deleteProductById($productId);
setFlash('success', 'Product deleted successfully.');
redirect('/admin_products.php');
