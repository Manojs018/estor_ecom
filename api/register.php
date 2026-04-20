<?php

require_once __DIR__ . '/../app/functions.php';

if (isLoggedIn()) {
    redirect('/products.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $phone === '' || $password === '') {
        setFlash('error', 'Please complete all required details to create your account.');
    } else {
        $pdo = getDbConnection();
        $checkStmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $checkStmt->execute([$email]);

        if ($checkStmt->fetch()) {
            setFlash('error', 'That email address is already registered with eStore.');
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (name, email, phone, password_hash) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $email, $phone, $hash]);

            $_SESSION['user'] = [
                'id' => (int) $pdo->lastInsertId(),
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
            ];

            setFlash('success', 'Your account has been created successfully. Welcome to eStore.');
            redirect('/products.php');
        }
    }
}

$pageTitle = 'Register';

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
    <section class="lp-section" style="padding-top: 100px; display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="lp-container">
            <div class="lp-blocks reveal-on-scroll" style="max-width: 1000px; margin: 0 auto; grid-template-columns: 1fr 1fr; overflow: hidden; padding: 0; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);">
                <!-- Form Panel -->
                <div style="padding: 60px; background: white;">
                    <span class="lp-label" style="margin-bottom: 12px;">Get Started</span>
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 16px; letter-spacing: -0.02em;">Create Account</h2>
                    <p style="color: var(--lp-text-soft); font-size: 1.05rem; margin-bottom: 40px; line-height: 1.6;">Join our community of builders and start sourcing high-quality components.</p>

                    <form method="post" class="auth-form-clean">
                        <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem; margin-bottom: 24px;">
                            Full Name
                            <input type="text" name="name" placeholder="John Doe" required style="padding: 14px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                        </label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                            <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem;">
                                Email Address
                                <input type="email" name="email" placeholder="name@example.com" required style="padding: 14px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                            </label>
                            <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem;">
                                Phone Number
                                <input type="text" name="phone" placeholder="+1..." required style="padding: 14px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                            </label>
                        </div>
                        <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem; margin-bottom: 32px;">
                            Password
                            <input type="password" name="password" placeholder="••••••••" required style="padding: 14px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                        </label>
                        <button type="submit" class="lp-btn lp-btn-primary" style="width: 100%;">Create Account</button>
                    </form>

                    <p style="margin-top: 40px; text-align: center; color: var(--lp-text-soft); font-size: 0.95rem;">
                        Already have an account? <a href="<?= BASE_URL; ?>/login.php" style="color: var(--lp-primary); font-weight: 700;">Sign in here</a>
                    </p>
                </div>

                <!-- Visual Panel -->
                <div style="padding: 60px; background: var(--lp-text); color: white; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden;">
                    <div style="z-index: 1;">
                        <h3 style="font-size: 2rem; font-weight: 800; margin-bottom: 24px; color: var(--lp-primary);">Builder Benefits.</h3>
                        <ul style="list-style: none; margin: 0; padding: 0; display: grid; gap: 24px;">
                            <li style="display: flex; gap: 16px; align-items: center;">
                                <div class="lp-icon-box" style="margin-bottom: 0; min-width: 40px; height: 40px; background: rgba(255,255,255,0.1); color: white;">📦</div>
                                <span>Track every order in real-time</span>
                            </li>
                            <li style="display: flex; gap: 16px; align-items: center;">
                                <div class="lp-icon-box" style="margin-bottom: 0; min-width: 40px; height: 40px; background: rgba(255,255,255,0.1); color: white;">💖</div>
                                <span>Save items to your personal wishlist</span>
                            </li>
                            <li style="display: flex; gap: 16px; align-items: center;">
                                <div class="lp-icon-box" style="margin-bottom: 0; min-width: 40px; height: 40px; background: rgba(255,255,255,0.1); color: white;">⚡</div>
                                <span>Early access to new component drops</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div style="position: absolute; top: -50px; left: -50px; width: 300px; height: 300px; background: var(--lp-primary); opacity: 0.2; border-radius: 50%; filter: blur(60px);"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../app/functions.php'; ?>
<?php require_once __DIR__ . '/../app/footer.php'; ?>
>
