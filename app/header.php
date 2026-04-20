<?php

require_once __DIR__ . '/functions.php';

$flash = getFlash();
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | ' . APP_NAME : APP_NAME; ?></title>
    <meta name="description" content="Premium electronics component shopping with refined browsing, wishlist saving, and secure ordering.">
    
    <!-- Design System Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Design System CSS -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/style.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/landing.css">
    <script src="<?= BASE_URL; ?>/assets/animations.js" defer></script>
    
    <?= isset($extraHeader) ? $extraHeader : ''; ?>

</head>
<body>
    <header class="lp-header">
        <div class="lp-container">
            <nav class="lp-nav">
                <a class="lp-brand" href="<?= BASE_URL; ?>/index.php">
                    ESTORE
                </a>

                <div class="lp-nav-links">
                    <a href="<?= BASE_URL; ?>/index.php">Overview</a>
                    <a href="<?= BASE_URL; ?>/products.php">Catalog</a>
                    <?php if ($user): ?>
                        <a href="<?= BASE_URL; ?>/wishlist.php">Wishlist</a>
                        <a href="<?= BASE_URL; ?>/orders.php">My Orders</a>
                    <?php endif; ?>
                </div>

                <div class="lp-nav-actions">
                    <?php if ($user): ?>
                        <div class="lp-user-profile">
                            <span style="font-weight: 700; font-size: 0.9rem; color: var(--lp-text-soft);">Hi, <?= e($user['name']); ?></span>
                            <a href="<?= BASE_URL; ?>/logout.php" class="lp-btn lp-btn-outline" style="padding: 8px 16px; font-size: 0.85rem;">Sign Out</a>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_URL; ?>/login.php" style="font-weight: 700; color: var(--lp-text-soft); font-size: 0.9rem; text-decoration: none;">Login</a>
                        <a href="<?= BASE_URL; ?>/register.php" class="lp-btn lp-btn-primary" style="padding: 8px 24px; font-size: 0.85rem;">Join</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <div class="flash-container">
        <?php if ($flash): ?>
            <div class="flash-pill flash-<?= e($flash['type']); ?>">
                <?= e($flash['message']); ?>
            </div>
        <?php endif; ?>
    </div>

    <main>
