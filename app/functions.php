<?php

require_once __DIR__ . '/../config/database.php';

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . BASE_URL . $path);
    exit;
}

function isLoggedIn(): bool
{
    return !empty($_SESSION['user']);
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        setFlash('error', 'Please login first.');
        redirect('/login.php');
    }
}

function isAdmin(): bool
{
    $user = currentUser();
    return $user && isset($user['email']) && strcasecmp($user['email'], ADMIN_EMAIL) === 0;
}

function requireAdmin(): void
{
    requireLogin();

    if (!isAdmin()) {
        setFlash('error', 'Only the owner/admin can access that page.');
        redirect('/orders.php');
    }
}

function getOrderStatuses(): array
{
    return [
        'Order placed',
        'Packed',
        'Shipped',
        'Out for delivery',
        'Delivered',
        'Cancelled',
    ];
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

function getFlash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function getProducts(): array
{
    $stmt = getDbConnection()->query('SELECT * FROM products ORDER BY created_at DESC');
    return $stmt->fetchAll();
}

function getDefaultProductFormData(): array
{
    return [
        'id' => 0,
        'name' => '',
        'category' => '',
        'price' => '',
        'image_url' => '',
        'short_description' => '',
        'description' => '',
        'details' => '',
    ];
}

function getProductById(int $id): ?array
{
    $stmt = getDbConnection()->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    return $product ?: null;
}

function isWishlisted(int $userId, int $productId): bool
{
    $stmt = getDbConnection()->prepare('SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?');
    $stmt->execute([$userId, $productId]);
    return (bool) $stmt->fetch();
}

function getWishlistItems(int $userId): array
{
    $stmt = getDbConnection()->prepare(
        'SELECT w.id AS wishlist_id, p.* 
         FROM wishlists w 
         INNER JOIN products p ON p.id = w.product_id
         WHERE w.user_id = ?
         ORDER BY w.created_at DESC'
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function normalizeProductInput(array $input): array
{
    return [
        'id' => (int) ($input['id'] ?? 0),
        'name' => trim($input['name'] ?? ''),
        'category' => trim($input['category'] ?? ''),
        'price' => trim((string) ($input['price'] ?? '')),
        'image_url' => trim($input['image_url'] ?? ''),
        'short_description' => trim($input['short_description'] ?? ''),
        'description' => trim($input['description'] ?? ''),
        'details' => trim($input['details'] ?? ''),
    ];
}

function validateProductInput(array $product): array
{
    $errors = [];

    if ($product['name'] === '') {
        $errors[] = 'Product name is required.';
    }

    if ($product['category'] === '') {
        $errors[] = 'Category is required.';
    }

    if ($product['price'] === '' || !is_numeric($product['price'])) {
        $errors[] = 'Please enter a valid price.';
    }

    if ($product['image_url'] === '') {
        $errors[] = 'Product image URL is required.';
    }

    if ($product['short_description'] === '') {
        $errors[] = 'Short description is required.';
    }

    if ($product['description'] === '') {
        $errors[] = 'Full description is required.';
    }

    if ($product['details'] === '') {
        $errors[] = 'Product details are required.';
    }

    return $errors;
}

function saveProduct(array $product): void
{
    $pdo = getDbConnection();

    if (!empty($product['id'])) {
        $stmt = $pdo->prepare(
            'UPDATE products
             SET name = ?, category = ?, price = ?, image_url = ?, short_description = ?, description = ?, details = ?
             WHERE id = ?'
        );
        $stmt->execute([
            $product['name'],
            $product['category'],
            $product['price'],
            $product['image_url'],
            $product['short_description'],
            $product['description'],
            $product['details'],
            $product['id'],
        ]);
        return;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO products (name, category, price, image_url, short_description, description, details)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        $product['name'],
        $product['category'],
        $product['price'],
        $product['image_url'],
        $product['short_description'],
        $product['description'],
        $product['details'],
    ]);
}

function deleteProductById(int $productId): void
{
    $stmt = getDbConnection()->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$productId]);
}

function sendOrderNotification(array $order, array $product, array $user): void
{
    $subject = 'New COD Order - ' . $product['name'];
    $messageLines = [
        'A new order has been placed on ' . APP_NAME . '.',
        '',
        'Customer Name: ' . $user['name'],
        'Customer Email: ' . $user['email'],
        'Phone Number: ' . $order['phone'],
        'Product: ' . $product['name'],
        'Quantity: ' . $order['quantity'],
        'Price Per Item: Rs. ' . number_format((float) $product['price'], 2),
        'Total Amount: Rs. ' . number_format((float) $order['total_amount'], 2),
        'Payment Mode: Cash on Delivery',
        'Delivery Address: ' . $order['address'],
        'Order Status: ' . $order['status'],
    ];

    $headers = [
        'From: ' . MAIL_FROM,
        'Reply-To: ' . $user['email'],
        'Content-Type: text/plain; charset=UTF-8',
    ];

    @mail(ADMIN_EMAIL, $subject, implode("\r\n", $messageLines), implode("\r\n", $headers));
}
