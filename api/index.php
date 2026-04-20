<?php

require_once __DIR__ . '/../app/functions.php';

$products = getProducts();
$featuredProducts = array_slice($products, 0, 4);
$pageTitle = 'Build Hardware Faster';

// Add new styles and scripts for the landing page
ob_start();
?>
<link rel="stylesheet" href="<?= BASE_URL; ?>/assets/landing.css">
<script src="<?= BASE_URL; ?>/assets/animations.js" defer></script>
<?php
$extraHeader = ob_get_clean();

require_once __DIR__ . '/../app/header.php';
?>

<div class="lp-body">
    <!-- Hero Section -->
    <section class="lp-hero reveal-on-scroll">
        <div class="lp-container">
            <span class="lp-label">Build Hardware Faster ⚡</span>
            <h1>The fastest way to <span class="highlight">design, prototype, and ship</span> electronics.</h1>
            <p>From simple circuits to complex systems, get reliable components that help you move from idea to working product—without friction.</p>
            <div class="lp-cta-group">
                <a href="<?= BASE_URL; ?>/products.php" class="lp-btn lp-btn-primary">👉 Get Started</a>
                <a href="#features" class="lp-btn lp-btn-outline">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Built for Builders -->
    <section id="features" class="lp-section lp-section-alt">
        <div class="lp-container">
            <div class="lp-section-header reveal-on-scroll">
                <span class="lp-label">Built for Builders</span>
                <h2>Everything you need to go from concept to creation.</h2>
            </div>
            <div class="lp-grid-4">
                <div class="lp-feature-card reveal-on-scroll">
                    <div class="lp-icon-box">📦</div>
                    <h3>Curated Components</h3>
                    <p>Hand-picked, high-quality components vetted for reliability.</p>
                </div>
                <div class="lp-feature-card reveal-on-scroll">
                    <div class="lp-icon-box">🧩</div>
                    <h3>Ready-to-use Modules</h3>
                    <p>Pre-assembled systems designed for immediate integration.</p>
                </div>
                <div class="lp-feature-card reveal-on-scroll">
                    <div class="lp-icon-box">⚡</div>
                    <h3>Reliable Performance</h3>
                    <p>Consistent results across all your development phases.</p>
                </div>
                <div class="lp-feature-card reveal-on-scroll">
                    <div class="lp-icon-box">🛠️</div>
                    <h3>Rapid Prototyping</h3>
                    <p>Designed specifically to reduce friction in the build process.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- What You Can Build -->
    <section class="lp-section">
        <div class="lp-container">
            <div class="lp-section-header reveal-on-scroll">
                <span class="lp-label">Possibilities</span>
                <h2>What You Can Build</h2>
                <p>Turn ideas into real, working systems.</p>
            </div>
            <div class="lp-blocks">
                <div class="lp-block reveal-on-scroll">
                    <div class="lp-icon-box">🏠</div>
                    <h4>Smart Automation</h4>
                    <p>Create intelligent environments with advanced control systems.</p>
                </div>
                <div class="lp-block reveal-on-scroll">
                    <div class="lp-icon-box">🌐</div>
                    <h4>IoT Devices</h4>
                    <p>Connected products that bridge the physical and digital worlds.</p>
                </div>
                <div class="lp-block reveal-on-scroll">
                    <div class="lp-icon-box">🤖</div>
                    <h4>Robotics</h4>
                    <p>Motion-based projects with precision control and feedback.</p>
                </div>
                <div class="lp-block reveal-on-scroll">
                    <div class="lp-icon-box">🔌</div>
                    <h4>Power Solutions</h4>
                    <p>Reliable electrical systems for diverse hardware needs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- One Platform -->
    <section class="lp-section lp-section-alt">
        <div class="lp-container">
            <div class="lp-section-header reveal-on-scroll">
                <span class="lp-label">All-in-One</span>
                <h2>One Platform. All Components.</h2>
                <p>Stop switching between suppliers. Everything works together. Out of the box.</p>
            </div>
            <div class="lp-grid-4">
                <div class="lp-feature-card reveal-on-scroll">
                    <h3>Core Components</h3>
                    <p>Resistors, capacitors, transistors, and more.</p>
                    <div class="lp-platform-list">
                        <span class="lp-chip">Resistors</span>
                        <span class="lp-chip">Capacitors</span>
                    </div>
                </div>
                <div class="lp-feature-card reveal-on-scroll">
                    <h3>Dev Boards</h3>
                    <p>The brains of your project. Arduino, ESP32, and more.</p>
                </div>
                <div class="lp-feature-card reveal-on-scroll">
                    <h3>Connectivity</h3>
                    <p>Wi-Fi, Bluetooth, RF, GSM. Always connected.</p>
                </div>
                <div class="lp-feature-card reveal-on-scroll">
                    <h3>Output Systems</h3>
                    <p>Motors, displays, and high-performance drivers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Built for Speed -->
    <section class="lp-section">
        <div class="lp-container">
            <div class="lp-section-header reveal-on-scroll">
                <span class="lp-label">Performance</span>
                <h2>Built for Speed ⚡</h2>
                <p>Move faster with the right tools designed for hardware innovators.</p>
            </div>
            <div class="lp-speed-row reveal-on-scroll">
                <div class="lp-speed-item">
                    <span>Fast</span>
                    <label>Decisions</label>
                </div>
                <div class="lp-speed-item">
                    <span>Reliable</span>
                    <label>Components</label>
                </div>
                <div class="lp-speed-item">
                    <span>Zero</span>
                    <label>Friction</label>
                </div>
            </div>
            <div class="lp-grid-4 reveal-on-scroll" style="margin-top: 40px;">
                <p>• Clear, no-confusion product info</p>
                <p>• Easy compatibility across modules</p>
                <p>• Faster decisions, faster builds</p>
                <p>• Designed to reduce trial and error</p>
            </div>
        </div>
    </section>

    <!-- Who This Is For -->
    <section class="lp-section lp-section-alt">
        <div class="lp-container reveal-on-scroll">
            <div class="lp-section-header">
                <span class="lp-label">Community</span>
                <h2>Who This Is For</h2>
            </div>
            <div class="lp-blocks" style="grid-template-columns: repeat(4, 1fr);">
                <div class="lp-block" style="padding: 20px; text-align: center;">Builders & Makers</div>
                <div class="lp-block" style="padding: 20px; text-align: center;">Product Developers</div>
                <div class="lp-block" style="padding: 20px; text-align: center;">Hardware Innovators</div>
                <div class="lp-block" style="padding: 20px; text-align: center;">Electronics Labs</div>
            </div>
        </div>
    </section>

    <!-- Featured Products Integration -->
    <section class="lp-section">
        <div class="lp-container">
            <div class="lp-section-header reveal-on-scroll">
                <span class="lp-label">Inventory</span>
                <h2>Featured Components</h2>
                <p>Start your build with our top-rated hardware.</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 24px;">
                <?php foreach ($featuredProducts as $product): ?>
                    <article class="lp-feature-card reveal-on-scroll" style="padding: 20px;">
                        <img src="<?= e($product['image_url']); ?>" alt="<?= e($product['name']); ?>" style="width: 100%; aspect-ratio: 1; object-fit: contain; margin-bottom: 15px;">
                        <h3 style="font-size: 1.1rem;"><?= e($product['name']); ?></h3>
                        <p style="font-weight: 700; color: var(--lp-primary); margin: 10px 0;">Rs. <?= number_format((float) $product['price'], 2); ?></p>
                        <a href="<?= BASE_URL; ?>/product.php?id=<?= (int) $product['id']; ?>" class="lp-btn lp-btn-outline" style="padding: 8px 16px; font-size: 0.9rem; width: 100%; display: block; text-align: center;">View Item</a>
                    </article>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="<?= BASE_URL; ?>/products.php" class="lp-btn lp-btn-primary">Explore All Components</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="lp-container">
        <div class="lp-footer-cta reveal-on-scroll">
            <span class="lp-label" style="background: rgba(255,255,255,0.1); color: white;">Get Started</span>
            <h2>Start Building Today</h2>
            <p style="color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto 40px;">Less searching. More building. Get what you need—fast.</p>
            <div class="lp-cta-group">
                <a href="<?= BASE_URL; ?>/products.php" class="lp-btn lp-btn-primary">👉 Explore Components</a>
                <a href="<?= BASE_URL; ?>/register.php" class="lp-btn lp-btn-outline" style="background: transparent; color: white;">Start Your Build</a>
            </div>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
