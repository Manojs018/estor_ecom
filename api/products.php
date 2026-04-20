<?php

require_once __DIR__ . '/../app/functions.php';

$products = getProducts();
$pageTitle = 'Electronics Catalog';

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
                <span class="lp-label">All components</span>
                <h2>Electronics Catalog</h2>
                <p>Browse our hand-picked selection of high-quality boards, sensors, and modules.</p>
            </div>

            <div class="lp-box-grid">
                <?php foreach ($products as $product): ?>
                    <article class="lp-box-card reveal-on-scroll">
                        <a href="<?= BASE_URL; ?>/product.php?id=<?= (int) $product['id']; ?>">
                            <img src="<?= e($product['image_url']); ?>" alt="<?= e($product['name']); ?>">
                        </a>
                        <div class="category-tag" style="margin-bottom: 4px;"><?= e($product['category']); ?></div>
                        <h3><?= e($product['name']); ?></h3>
                        <div class="price">Rs. <?= number_format((float) $product['price'], 2); ?></div>
                        <a href="<?= BASE_URL; ?>/checkout.php?product_id=<?= (int) $product['id']; ?>" class="btn-add">Buy Now</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
