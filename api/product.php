<?php

require_once __DIR__ . '/../app/functions.php';

$productId = (int) ($_GET['id'] ?? 0);
$product = getProductById($productId);

if (!$product) {
    setFlash('error', 'Product not found.');
    redirect('/products.php');
}

$user = currentUser();
$wishlisted = $user ? isWishlisted((int) $user['id'], $productId) : false;

$pageTitle = $product['name'];

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
    <div class="lp-container" style="padding: 100px 24px;">
        <div class="detail-layout" style="grid-template-columns: 1fr 1fr; gap: 80px; align-items: start; display: grid;">
            <section class="lp-feature-card reveal-on-scroll" style="padding: 40px; position: sticky; top: 120px;">
                <img class="product-image" src="<?= e($product['image_url']); ?>" alt="<?= e($product['name']); ?>" style="width: 100%; aspect-ratio: 1; object-fit: contain;">
            </section>
            
            <section class="reveal-on-scroll">
                <span class="lp-label"><?= e($product['category']); ?></span>
                <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 20px;"><?= e($product['name']); ?></h1>
                <p class="description" style="font-size: 1.25rem; color: var(--lp-text-soft); margin-bottom: 30px;">
                    <?= e($product['short_description']); ?>
                </p>
                
                <div class="price" style="font-size: 2.5rem; font-weight: 800; color: var(--lp-primary); margin-bottom: 40px;">
                    Rs. <?= number_format((float) $product['price'], 2); ?>
                </div>

                <div class="lp-block" style="margin-bottom: 40px;">
                    <h4 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 15px;">Technical Specifications</h4>
                    <p style="font-size: 1rem; color: var(--lp-text-soft); line-height: 1.8;">
                        <?= nl2br(e($product['description'])); ?>
                    </p>
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--lp-border); font-size: 0.95rem; color: var(--lp-text-soft);">
                        <strong>Key Details:</strong> <?= e($product['details']); ?>
                    </div>
                </div>

                <div class="lp-cta-group" style="justify-content: flex-start;">
                    <?php if ($user): ?>
                        <a class="lp-btn lp-btn-outline" style="flex: 1;" href="<?= BASE_URL; ?>/toggle_wishlist.php?product_id=<?= (int) $product['id']; ?>">
                            <?= $wishlisted ? 'Remove from Wishlist' : 'Add to Wishlist'; ?>
                        </a>
                        <a class="lp-btn lp-btn-primary" style="flex: 1;" href="<?= BASE_URL; ?>/checkout.php?product_id=<?= (int) $product['id']; ?>">
                            Buy Now
                        </a>
                    <?php else: ?>
                        <a class="lp-btn lp-btn-outline" style="flex: 1;" href="<?= BASE_URL; ?>/login.php">Login to Save</a>
                        <a class="lp-btn lp-btn-primary" style="flex: 1;" href="<?= BASE_URL; ?>/login.php">Login to Buy</a>
                    <?php endif; ?>
                </div>

                <div style="margin-top: 60px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div class="lp-feature-card" style="padding: 20px; display: flex; gap: 16px; align-items: center;">
                        <div class="lp-icon-box" style="margin-bottom: 0; min-width: 48px;">🛡️</div>
                        <div>
                            <div style="font-weight: 700; font-size: 1rem;">Quality Assurance</div>
                            <div style="font-size: 0.85rem; color: var(--lp-text-soft);">100% Genuine Components</div>
                        </div>
                    </div>
                    <div class="lp-feature-card" style="padding: 20px; display: flex; gap: 16px; align-items: center;">
                        <div class="lp-icon-box" style="margin-bottom: 0; min-width: 48px;">🚀</div>
                        <div>
                            <div style="font-weight: 700; font-size: 1rem;">Rapid Delivery</div>
                            <div style="font-size: 0.85rem; color: var(--lp-text-soft);">Secure Global Shipping</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../app/footer.php'; ?>
