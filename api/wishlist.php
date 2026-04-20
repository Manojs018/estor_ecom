<?php

require_once __DIR__ . '/../app/functions.php';

requireLogin();

$items = getWishlistItems((int) currentUser()['id']);
$pageTitle = 'Wishlist';
require_once __DIR__ . '/../app/header.php';
?>
<section class="section-block" style="padding-top: 60px;">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Personal Collection</span>
            <h1>Your Wishlist</h1>
            <p>Keep your preferred products in one place and return whenever you are ready to purchase.</p>
        </div>

        <?php if (!$items): ?>
            <div style="background: var(--surface); padding: 60px; border-radius: var(--radius-lg); text-align: center; border: 1px solid var(--border);">
                <div style="font-size: 3rem; margin-bottom: 20px;">✨</div>
                <h3 style="margin-bottom: 10px;">Your wishlist is currently empty.</h3>
                <p style="color: var(--text-secondary); margin-bottom: 30px;">Discover our curated collection of premium electrical essentials.</p>
                <a class="btn btn-primary" href="<?= BASE_URL; ?>/products.php">Discover Products</a>
            </div>
        <?php else: ?>
            <div class="product-grid-premium">
                <?php foreach ($items as $item): ?>
                    <article class="product-card-premium">
                        <a href="<?= BASE_URL; ?>/product.php?id=<?= (int) $item['id']; ?>">
                            <img src="<?= e($item['image_url']); ?>" alt="<?= e($item['name']); ?>">
                        </a>
                        <div class="product-card-body">
                            <div class="product-meta-row">
                                <span class="category-tag"><?= e($item['category']); ?></span>
                                <span class="price-tag">Rs. <?= number_format((float) $item['price'], 2); ?></span>
                            </div>
                            <h3><?= e($item['name']); ?></h3>
                            <p><?= e($item['short_description']); ?></p>
                            <div class="card-actions-row">
                                <a class="btn btn-secondary btn-sm" href="<?= BASE_URL; ?>/product.php?id=<?= (int) $item['id']; ?>">Details</a>
                                <a class="btn btn-primary btn-sm" href="<?= BASE_URL; ?>/checkout.php?product_id=<?= (int) $item['id']; ?>">Buy Now</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../app/footer.php'; ?>
