<?php

require_once __DIR__ . '/../app/functions.php';

if (isLoggedIn()) {
    redirect('/products.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        setFlash('error', 'Please enter both your email address and password.');
    } else {
        $stmt = getDbConnection()->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            setFlash('error', 'We could not verify those login details. Please try again.');
        } else {
            $_SESSION['user'] = [
                'id' => (int) $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
            ];

            setFlash('success', 'Welcome back. You are now signed in.');
            redirect('/products.php');
        }
    }
}

$pageTitle = 'Login';

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
                    <span class="lp-label" style="margin-bottom: 12px;">Secure Access</span>
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 16px; letter-spacing: -0.02em;">Welcome Back</h2>
                    <p style="color: var(--lp-text-soft); font-size: 1.05rem; margin-bottom: 40px; line-height: 1.6;">Sign in to access your dashboard, track orders, and manage components.</p>

                    <form method="post" class="auth-form-clean">
                        <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem; margin-bottom: 24px;">
                            Email Address
                            <input type="email" name="email" placeholder="name@example.com" required style="padding: 14px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                        </label>
                        <label style="display: flex; flex-direction: column; gap: 8px; font-weight: 600; font-size: 0.9rem; margin-bottom: 12px;">
                            Password
                            <input type="password" name="password" placeholder="••••••••" required style="padding: 14px; border: 1px solid var(--lp-border); border-radius: 8px; font-family: inherit;">
                        </label>
                        <div style="text-align: right; margin-bottom: 32px;">
                            <a href="#" style="font-size: 0.85rem; font-weight: 600; color: var(--lp-primary);">Forgot password?</a>
                        </div>
                        <button type="submit" class="lp-btn lp-btn-primary" style="width: 100%;">Sign In</button>
                    </form>

                    <p style="margin-top: 40px; text-align: center; color: var(--lp-text-soft); font-size: 0.95rem;">
                        Don't have an account? <a href="<?= BASE_URL; ?>/register.php" style="color: var(--lp-primary); font-weight: 700;">Join the community</a>
                    </p>
                </div>

                <!-- Visual Panel -->
                <div style="padding: 60px; background: var(--lp-text); color: white; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden;">
                    <div style="z-index: 1;">
                        <h3 style="font-size: 2rem; font-weight: 800; margin-bottom: 24px; color: var(--lp-primary);">Build Beyond.</h3>
                        <p style="color: rgba(255,255,255,0.7); line-height: 1.8; font-size: 1.1rem;">"The most professional way to source electronics components. Clean, fast, and reliable."</p>
                        
                    </div>
                    
                    <div style="position: absolute; bottom: -50px; right: -50px; width: 300px; height: 300px; background: var(--lp-primary); opacity: 0.2; border-radius: 50%; filter: blur(60px);"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
