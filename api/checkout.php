<?php

require_once __DIR__ . '/../app/functions.php';

requireLogin();

$productId = (int) ($_GET['product_id'] ?? 0);
$product = getProductById($productId);

if (!$product) {
    setFlash('error', 'Product not found.');
    redirect('/products.php');
}

$user = currentUser();
$pageTitle = 'Secure Checkout';

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
                <span class="lp-label">Final Step</span>
                <h2>Secure Checkout</h2>
                <p>Complete your order for the <?= e($product['name']); ?>.</p>
            </div>

            <div class="lp-blocks reveal-on-scroll" style="grid-template-columns: 1.2fr 0.8fr; gap: 40px; align-items: start;">
                <!-- Billing/Shipping Form -->
                <div class="lp-block" style="padding: 40px;">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 24px;">Shipment Information</h3>
                    <form method="post" action="<?= BASE_URL; ?>/place_order.php" class="auth-form-clean">
                        <input type="hidden" name="product_id" value="<?= (int) $product['id']; ?>">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem;">
                                Full Name
                                <input type="text" name="name" value="<?= e($user['name']); ?>" required style="padding: 12px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                            </label>
                            <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem;">
                                Email Address
                                <input type="email" name="email" value="<?= e($user['email']); ?>" required style="padding: 12px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                            </label>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                            <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem;">
                                Phone Number
                                <input type="text" name="phone" value="<?= e($user['phone']); ?>" required style="padding: 12px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                            </label>
                            <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem;">
                                Quantity
                                <input type="number" name="quantity" value="1" min="1" required style="padding: 12px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                            </label>
                        </div>

                        <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem; margin-top: 20px;">
                            Delivery Address
                            <textarea name="address" required style="width: 100%; min-height: 100px; padding: 12px; border-radius: 8px; border: 1px solid var(--lp-border); font-family: inherit; font-size: 1rem;"></textarea>
                        </label>

                        <div style="margin-top: 32px; padding: 16px; background: var(--lp-primary-soft); color: var(--lp-primary); border-radius: 8px; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 12px;">
                            <span>💵</span>
                            Payment Mode: Cash on Delivery (COD)
                        </div>

                        <button type="submit" class="lp-btn lp-btn-primary" style="width: 100%; margin-top: 32px;">Confirm & Place Order</button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="lp-block" style="padding: 40px; background: var(--lp-surface); border: 1px solid var(--lp-border);">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 24px;">Order Summary</h3>
                    <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid var(--lp-border); margin-bottom: 24px; display: flex; gap: 16px; align-items: center;">
                        <img src="<?= e($product['image_url']); ?>" alt="<?= e($product['name']); ?>" style="width: 80px; height: 80px; object-fit: contain; border-radius: 8px;">
                        <div>
                            <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 4px;"><?= e($product['name']); ?></h4>
                            <div style="font-weight: 800; color: var(--lp-primary); font-size: 1.1rem;">Rs. <?= number_format((float) $product['price'], 2); ?></div>
                        </div>
                    </div>

                    <div style="display: grid; gap: 16px; font-size: 0.95rem;">
                        <div style="display: flex; justify-content: space-between; color: var(--lp-text-soft);">
                            <span>Subtotal</span>
                            <span>Rs. <?= number_format((float) $product['price'], 2); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: var(--lp-text-soft);">
                            <span>Shipping</span>
                            <span style="color: #10b981; font-weight: 700;">FREE</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 16px; border-top: 1px solid var(--lp-border); margin-top: 8px; font-size: 1.25rem;">
                            <span style="font-weight: 800;">Total</span>
                            <span style="font-weight: 800; color: var(--lp-primary);">Rs. <?= number_format((float) $product['price'], 2); ?></span>
                        </div>
                    </div>

                    <div style="margin-top: 40px; font-size: 0.85rem; color: var(--lp-text-soft); line-height: 1.5; text-align: center;">
                        By clicking "Confirm", you agree to our Terms of Service and Privacy Policy. Your order will be processed via Tech Express priority shipping.
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
