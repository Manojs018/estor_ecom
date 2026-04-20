<?php

require_once __DIR__ . '/config.php';

function getDbConnection(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';

    // TiDB Cloud and most cloud providers require SSL for public connections
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    if (getenv('VERCEL') === '1') {
        // Fail-safe: Check common Linux CA certificate paths
        $caPaths = [
            '/etc/pki/tls/certs/ca-bundle.crt',
            '/etc/ssl/certs/ca-certificates.crt',
            '/etc/ssl/cert.pem'
        ];
        
        $caConstant = (PHP_VERSION_ID >= 80500 && defined('Pdo\Mysql::ATTR_SSL_CA')) 
            ? constant('Pdo\Mysql::ATTR_SSL_CA') 
            : PDO::MYSQL_ATTR_SSL_CA;

        foreach ($caPaths as $path) {
            if (is_file($path)) {
                $options[$caConstant] = $path;
                break;
            }
        }
        
        // Suppress warning and force SSL verification off for the cloud proxy
        // We use @ to avoid the PHP 8.5 deprecation notice on the old constant name
        @$options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
    }

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    return $pdo;
}
