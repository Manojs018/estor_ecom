<?php

require_once __DIR__ . '/../app/functions.php';

requireLogin();

$productId = (int) ($_GET['product_id'] ?? 0);
$product = getProductById($productId);

if (!$product) {
    setFlash('error', 'Product not found.');
    redirect('/products.php');
}

$userId = (int) currentUser()['id'];
$pdo = getDbConnection();

if (isWishlisted($userId, $productId)) {
    $stmt = $pdo->prepare('DELETE FROM wishlists WHERE user_id = ? AND product_id = ?');
    $stmt->execute([$userId, $productId]);
    setFlash('success', 'Item removed from wishlist.');
} else {
    $stmt = $pdo->prepare('INSERT INTO wishlists (user_id, product_id) VALUES (?, ?)');
    $stmt->execute([$userId, $productId]);
    setFlash('success', 'Item added to wishlist.');
}

redirect('/product.php?id=' . $productId);
