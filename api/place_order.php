<?php

require_once __DIR__ . '/../app/functions.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/products.php');
}

$productId = (int) ($_POST['product_id'] ?? 0);
$quantity = max(1, (int) ($_POST['quantity'] ?? 1));
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

$product = getProductById($productId);

if (!$product || $address === '' || $phone === '' || $name === '' || $email === '') {
    setFlash('error', 'Please complete all order fields.');
    redirect('/checkout.php?product_id=' . $productId);
}

$totalAmount = (float) $product['price'] * $quantity;
$status = 'Order placed';
$userId = (int) currentUser()['id'];

$stmt = getDbConnection()->prepare(
    'INSERT INTO orders (user_id, product_id, customer_name, customer_email, phone, address, quantity, total_amount, payment_method, status)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
);

$stmt->execute([
    $userId,
    $productId,
    $name,
    $email,
    $phone,
    $address,
    $quantity,
    $totalAmount,
    'Cash on Delivery',
    $status,
]);

$orderId = (int) getDbConnection()->lastInsertId();
$order = [
    'id' => $orderId,
    'phone' => $phone,
    'address' => $address,
    'quantity' => $quantity,
    'total_amount' => $totalAmount,
    'status' => $status,
];

sendOrderNotification($order, $product, [
    'name' => $name,
    'email' => $email,
]);

setFlash('success', 'Order placed successfully. You can track it in your orders page.');
redirect('/orders.php');
