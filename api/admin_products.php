<?php

require_once __DIR__ . '/../app/functions.php';

requireAdmin();

$editId = (int) ($_GET['edit'] ?? 0);
$formData = getDefaultProductFormData();

if ($editId > 0) {
    $existing = getProductById($editId);
    if ($existing) {
        $formData = $existing;
    } else {
        setFlash('error', 'The selected product could not be found.');
        redirect('/admin_products.php');
    }
}

if (!empty($_SESSION['product_form_data'])) {
    $formData = array_merge($formData, $_SESSION['product_form_data']);
    unset($_SESSION['product_form_data']);
}

$products = getProducts();
$pageTitle = 'Admin Products';
require_once __DIR__ . '/../app/header.php';
?>
<section class="section-block" style="padding-top: 60px;">
    <div class="container">
        <div class="section-heading" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
            <div>
                <span class="eyebrow">Inventory Control</span>
                <h1>Product Management</h1>
                <p>Manage your high-end catalog directly from the command center.</p>
            </div>
            <a class="btn btn-secondary" href="<?= BASE_URL; ?>/admin_orders.php">View All Orders</a>
        </div>

        <div style="display: grid; grid-template-columns: 400px 1fr; gap: 40px; align-items: start;">
            <aside style="background: var(--surface); padding: 30px; border-radius: var(--radius-lg); border: 1px solid var(--border); position: sticky; top: 120px;">
                <h3 style="margin-bottom: 20px;"><?= !empty($formData['id']) ? 'Edit Product' : 'Add New Product'; ?></h3>
                <form method="post" action="<?= BASE_URL; ?>/save_product.php" class="auth-form-clean" style="margin-top: 0;">
                    <input type="hidden" name="id" value="<?= (int) $formData['id']; ?>">

                    <label>
                        Product Name
                        <input type="text" name="name" value="<?= e((string) $formData['name']); ?>" required>
                    </label>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <label>
                            Category
                            <input type="text" name="category" value="<?= e((string) $formData['category']); ?>" required>
                        </label>
                        <label>
                            Price
                            <input type="text" name="price" value="<?= e((string) $formData['price']); ?>" required>
                        </label>
                    </div>

                    <label>
                        Product Image URL
                        <input type="text" name="image_url" value="<?= e((string) $formData['image_url']); ?>" required>
                    </label>

                    <label>
                        Short Description
                        <input type="text" name="short_description" value="<?= e((string) $formData['short_description']); ?>" required>
                    </label>

                    <label>
                        Full Description
                        <textarea name="description" required style="width: 100%; min-height: 80px; padding: 12px; border-radius: var(--radius-md); border: 1px solid var(--border); font-family: inherit;"><?= e((string) $formData['description']); ?></textarea>
                    </label>

                    <label>
                        Key Details
                        <textarea name="details" required style="width: 100%; min-height: 80px; padding: 12px; border-radius: var(--radius-md); border: 1px solid var(--border); font-family: inherit;"><?= e((string) $formData['details']); ?></textarea>
                    </label>

                    <div style="display: grid; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-primary"><?= !empty($formData['id']) ? 'Update Catalog' : 'Publish Product'; ?></button>
                        <?php if (!empty($formData['id'])): ?>
                            <a class="btn btn-secondary btn-sm" href="<?= BASE_URL; ?>/admin_products.php">Cancel Editing</a>
                        <?php endif; ?>
                    </div>
                </form>
            </aside>

            <main>
                <div style="display: grid; gap: 20px;">
                    <?php foreach ($products as $product): ?>
                        <article style="background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border); display: grid; grid-template-columns: 100px 1fr auto; gap: 20px; padding: 20px; align-items: center;">
                            <img src="<?= e($product['image_url']); ?>" alt="<?= e($product['name']); ?>" style="width: 100px; height: 100px; border-radius: var(--radius-sm); object-fit: cover; background: #f5f5f5;">
                            
                            <div>
                                <span class="category-tag" style="font-size: 0.7rem;"><?= e($product['category']); ?></span>
                                <h3 style="font-size: 1.1rem; margin: 4px 0;"><?= e($product['name']); ?></h3>
                                <div style="font-weight: 800; color: var(--primary);">Rs. <?= number_format((float) $product['price'], 2); ?></div>
                                <p style="font-size: 0.85rem; color: #666; margin-top: 5px;"><?= e($product['short_description']); ?></p>
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <a class="btn btn-secondary btn-sm" href="<?= BASE_URL; ?>/admin_products.php?edit=<?= (int) $product['id']; ?>">Edit</a>
                                <form method="post" action="<?= BASE_URL; ?>/delete_product.php" onsubmit="return confirm('Delete this product?');">
                                    <input type="hidden" name="id" value="<?= (int) $product['id']; ?>">
                                    <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;">Delete</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../app/footer.php'; ?>
