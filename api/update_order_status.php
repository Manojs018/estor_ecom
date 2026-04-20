<?php

require_once __DIR__ . '/../app/functions.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/admin_orders.php');
}

$orderId = (int) ($_POST['order_id'] ?? 0);
$status = trim($_POST['status'] ?? '');
$allowedStatuses = getOrderStatuses();

if ($orderId <= 0 || !in_array($status, $allowedStatuses, true)) {
    setFlash('error', 'Invalid order update request.');
    redirect('/admin_orders.php');
}

$stmt = getDbConnection()->prepare('UPDATE orders SET status = ? WHERE id = ?');
$stmt->execute([$status, $orderId]);

setFlash('success', 'Order status updated successfully.');
redirect('/admin_orders.php');
