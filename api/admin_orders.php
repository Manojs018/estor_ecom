<?php

require_once __DIR__ . '/../app/functions.php';

requireAdmin();

$stmt = getDbConnection()->query(
    'SELECT o.*, p.name AS product_name, p.image_url
     FROM orders o
     INNER JOIN products p ON p.id = o.product_id
     ORDER BY o.created_at DESC'
);
$orders = $stmt->fetchAll();
$statuses = getOrderStatuses();

$pageTitle = 'Admin Orders';
require_once __DIR__ . '/../app/header.php';
?>
<section class="section-block" style="padding-top: 60px;">
    <div class="container">
        <div class="section-heading" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
            <div>
                <span class="eyebrow">Operations Suite</span>
                <h1>Order Management</h1>
                <p>Monitor incoming orders, review customer details, and keep fulfillment updates accurate.</p>
            </div>
            <a class="btn btn-secondary" href="<?= BASE_URL; ?>/admin_products.php">Manage Inventory</a>
        </div>

        <?php if (!$orders): ?>
            <div style="background: var(--surface); padding: 60px; border-radius: var(--radius-lg); text-align: center; border: 1px solid var(--border);">
                <div style="font-size: 3rem; margin-bottom: 20px;">📋</div>
                <h3 style="margin-bottom: 10px;">No customer orders have been placed yet.</h3>
                <p style="color: var(--text-secondary);">Orders will appear here once customers start checking out.</p>
            </div>
        <?php else: ?>
            <div style="display: grid; gap: 24px;">
                <?php foreach ($orders as $order): ?>
                     <article style="background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border); display: grid; grid-template-columns: 120px 1fr 1fr; gap: 40px; padding: 24px; align-items: start;">
                        <img src="<?= e($order['image_url']); ?>" alt="<?= e($order['product_name']); ?>" style="width: 120px; height: 120px; border-radius: var(--radius-sm); object-fit: cover; background: #f5f5f5;">
                        
                        <div style="display: grid; gap: 12px;">
                            <div>
                                <span style="font-size: 0.8rem; font-weight: 800; color: var(--primary); text-transform: uppercase;">Order #<?= (int) $order['id']; ?></span>
                                <h3 style="margin: 4px 0; font-size: 1.25rem;"><?= e($order['product_name']); ?></h3>
                            </div>
                            <div style="font-size: 0.9rem; color: var(--text-secondary);">
                                <div style="margin-bottom: 4px;"><strong>Customer:</strong> <?= e($order['customer_name']); ?></div>
                                <div style="margin-bottom: 4px;"><strong>Contact:</strong> <?= e($order['phone']); ?></div>
                                <div><strong>Email:</strong> <?= e($order['customer_email']); ?></div>
                            </div>
                            <div style="font-size: 0.85rem; padding: 12px; background: var(--bg); border-radius: var(--radius-sm); border-left: 3px solid var(--primary);">
                                <strong>Shipping Address:</strong><br><?= e($order['address']); ?>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 20px; text-align: right;">
                            <div>
                                <div style="font-size: 0.8rem; color: #999; margin-bottom: 4px;">Order Total</div>
                                <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary);">Rs. <?= number_format((float) $order['total_amount'], 2); ?></div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">Quantity: <?= (int) $order['quantity']; ?></div>
                            </div>
                            
                            <form method="post" action="<?= BASE_URL; ?>/update_order_status.php" style="display: grid; gap: 10px; background: #f9f9f9; padding: 15px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                                <input type="hidden" name="order_id" value="<?= (int) $order['id']; ?>">
                                <label style="text-align: left; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); display: block;">
                                    Change Status
                                    <select name="status" required style="width: 100%; margin-top: 5px; padding: 8px; border-radius: 6px; border: 1px solid var(--border); font-family: inherit;">
                                        <?php foreach ($statuses as $status): ?>
                                            <option value="<?= e($status); ?>" <?= $order['status'] === $status ? 'selected' : ''; ?>>
                                                <?= e($status); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                                <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">Update Status</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../app/footer.php'; ?>
