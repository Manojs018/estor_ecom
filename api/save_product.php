<?php

require_once __DIR__ . '/../app/functions.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/admin_products.php');
}

$product = normalizeProductInput($_POST);
$errors = validateProductInput($product);

if ($errors) {
    $_SESSION['product_form_data'] = $product;
    setFlash('error', $errors[0]);
    redirect('/admin_products.php' . (!empty($product['id']) ? '?edit=' . (int) $product['id'] : ''));
}

saveProduct($product);

setFlash('success', !empty($product['id']) ? 'Product updated successfully.' : 'Product added successfully.');
redirect('/admin_products.php');
