<?php

define('APP_NAME', 'eStore');

// Database Configuration - Use Environment Variables for Security
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'eStore');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

define('ADMIN_EMAIL', getenv('ADMIN_EMAIL') ?: 'cac1552005@gmail.com');
define('MAIL_FROM', getenv('MAIL_FROM') ?: 'noreply@estore.local');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Kolkata');

// Base URL calculation for cross-platform compatibility
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$basePath = rtrim(str_replace('/index.php', '', dirname($scriptName)), '/');

if ($basePath === '' || $basePath === '.') {
    $basePath = '';
}

// On Vercel or other proxies, the base path is usually root
if (getenv('VERCEL') === '1') {
    define('BASE_URL', '');
} else {
    define('BASE_URL', $basePath);
}
