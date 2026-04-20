<?php

require_once __DIR__ . '/../app/functions.php';

requireLogin();

$stmt = getDbConnection()->prepare(
    'SELECT o.*, p.name AS product_name, p.image_url
     FROM orders o
     INNER JOIN products p ON p.id = o.product_id
     WHERE o.user_id = ?
     ORDER BY o.created_at DESC'
);
$stmt->execute([(int) currentUser()['id']]);
$orders = $stmt->fetchAll();

$pageTitle = 'Your Orders';

// Add new styles and scripts
ob_start();
?>
<link rel="stylesheet" href="<?= BASE_URL; ?>/assets/landing.css">
<script src="<?= BASE_URL; ?>/assets/animations.js" defer></script>
<?php
$extraHeader = ob_get_clean();

require_once __DIR__ . '/../app/header.php';
?>

<div class="lp-body">
    <section class="lp-section" style="padding-top: 60px;">
        <div class="lp-container">
            <div class="lp-section-header reveal-on-scroll">
                <span class="lp-label">Account</span>
                <h2>Order History</h2>
                <p>Track and manage your recent electronic component purchases.</p>
            </div>

            <?php if (!$orders): ?>
                <div class="lp-block reveal-on-scroll" style="text-align: center; padding: 80px 40px;">
                    <div class="lp-icon-box" style="margin: 0 auto 24px; font-size: 2rem;">📦</div>
                    <h3 style="margin-bottom: 12px;">You haven't placed any orders yet.</h3>
                    <p style="color: var(--lp-text-soft); margin-bottom: 32px;">Your electronics building journey starts here.</p>
                    <a class="lp-btn lp-btn-primary" href="<?= BASE_URL; ?>/products.php">Start Shopping</a>
                </div>
            <?php else: ?>
                <div style="display: grid; gap: 24px;">
                    <?php foreach ($orders as $order): ?>
                        <article class="lp-block reveal-on-scroll" style="display: grid; grid-template-columns: 100px 1fr auto; gap: 32px; align-items: center; padding: 32px;">
                            <img src="<?= e($order['image_url']); ?>" alt="<?= e($order['product_name']); ?>" style="width: 100px; height: 100px; object-fit: contain; background: var(--lp-surface); border-radius: 12px; border: 1px solid var(--lp-border);">
                            
                            <div>
                                <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
                                    <span style="font-size: 0.75rem; font-weight: 800; color: var(--lp-primary); text-transform: uppercase; background: var(--lp-primary-soft); padding: 4px 10px; border-radius: 99px;">ID #<?= (int) $order['id']; ?></span>
                                    <span style="font-size: 0.85rem; color: var(--lp-text-soft);">Placed on <?= date('d M, Y', strtotime($order['created_at'])); ?></span>
                                </div>
                                <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 12px;"><?= e($order['product_name']); ?></h3>
                                <div style="display: flex; gap: 32px; font-size: 0.95rem; color: var(--lp-text-soft);">
                                    <span>Quantity: <strong style="color: var(--lp-text); font-weight: 700;"><?= (int) $order['quantity']; ?></strong></span>
                                    <span>Total: <strong style="color: var(--lp-primary); font-weight: 800;">Rs. <?= number_format((float) $order['total_amount'], 2); ?></strong></span>
                                </div>
                                <div style="margin-top: 16px; font-size: 0.85rem; color: var(--lp-text-soft); display: flex; gap: 8px; align-items: center;">
                                    <span>📍</span>
                                    <?= e($order['address']); ?>
                                </div>
                            </div>

                            <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 20px;">
                                <div style="padding: 8px 16px; border-radius: 99px; background: #ecfdf5; color: #059669; font-weight: 800; font-size: 0.85rem; border: 1px solid #10b981;">
                                    <?= e($order['status']); ?>
                                </div>
                                <a class="lp-btn lp-btn-outline" style="padding: 10px 20px; font-size: 0.9rem;" href="<?= BASE_URL; ?>/product.php?id=<?= (int) $order['product_id']; ?>">View Item</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
