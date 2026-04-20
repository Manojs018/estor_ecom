<?php

require_once __DIR__ . '/../app/functions.php';

try {
    $pdo = getDbConnection();

    echo "<h1>Database Synchronizing...</h1>";

    // 1. Create Tables
    $schema = "
        CREATE TABLE IF NOT EXISTS `products` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `category` varchar(100) NOT NULL,
          `price` decimal(10,2) NOT NULL,
          `image_url` text NOT NULL,
          `short_description` varchar(255) NOT NULL,
          `description` text NOT NULL,
          `details` text NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `email` varchar(255) NOT NULL,
          `phone` varchar(20) NOT NULL,
          `password_hash` varchar(255) NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY (`id`),
          UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `orders` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `product_id` int(11) NOT NULL,
          `quantity` int(11) NOT NULL,
          `total_amount` decimal(10,2) NOT NULL,
          `address` text NOT NULL,
          `phone` varchar(20) NOT NULL,
          `status` varchar(50) NOT NULL DEFAULT 'Order placed',
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY (`id`),
          KEY `user_id` (`user_id`),
          KEY `product_id` (`product_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `wishlists` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `product_id` int(11) NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY (`id`),
          KEY `user_id` (`user_id`),
          KEY `product_id` (`product_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $pdo->exec($schema);
    echo "<p>✅ Tables verified/created.</p>";

    // 2. Seed Data
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE products; SET FOREIGN_KEY_CHECKS = 1;');

    $products = [
        ['Premium Gaming Motherboard', 'Hardware', 12500.00, 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=600', 'High-end motherboard for elite PC builds.', 'A professional-grade motherboard designed for extreme performance and stability.', 'Chipset: Z790, Socket: LGA1700'],
        ['High-Performance CPU', 'Hardware', 28000.00, 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?auto=format&fit=crop&q=80&w=600', 'Multi-core processor for heavy multitasking.', 'Unleash extreme power with this multi-core processor optimized for gaming.', 'Cores: 12, Threads: 24, Clock: 5.2 GHz'],
        ['Arduino Development Kit', 'Controllers', 1200.00, 'https://images.unsplash.com/photo-1553406830-ef2513450d76?auto=format&fit=crop&q=80&w=600', 'Standard micro-controller for robotics.', 'The ultimate board for learning electronics and coding.', 'Model: Uno R3, USB: Type B'],
        ['Industrial Circuit Board', 'Modules', 3500.00, 'https://images.unsplash.com/photo-1555664424-778a1e5e1b48?auto=format&fit=crop&q=80&w=600', 'Pre-assembled control module.', 'A robust industrial circuit board for high-reliability systems.', 'Input: 12V-24V DC'],
        ['Advanced Robotics Sensors', 'Sensors', 850.00, 'https://images.unsplash.com/photo-1610051187474-90dbf8832386?auto=format&fit=crop&q=80&w=600', 'High-precision detection module.', 'Premium sensors for environmental detection and motion sensing.', 'Type: Ultrasonic/IR'],
        ['High-Speed Memory Module', 'Hardware', 6500.00, 'https://images.unsplash.com/photo-1562408590-e32931084e23?auto=format&fit=crop&q=80&w=600', 'Low-latency RAM for smooth performance.', 'Boost your system speed with this high-capacity DDR5 module.', 'Capacity: 16GB, Type: DDR5'],
        ['Solid State Drive (SSD)', 'Hardware', 8900.00, 'https://images.unsplash.com/photo-1597733336794-12d05021d510?auto=format&fit=crop&q=80&w=600', 'Lightning fast NVMe storage.', 'Transform your load times with high-speed NVMe flash storage.', 'Capacity: 1TB, Interface: PCIe Gen4'],
        ['Precision Multimeter', 'Tools', 4500.00, 'https://images.unsplash.com/photo-1581091215367-9b6c00b3035a?auto=format&fit=crop&q=80&w=600', 'Digital testing equipment for electronics.', 'A high-precision digital multimeter for testing circuits.', 'Type: Auto-ranging, Backlit'],
    ];

    $stmt = $pdo->prepare('INSERT INTO products (name, category, price, image_url, short_description, description, details) VALUES (?, ?, ?, ?, ?, ?, ?)');
    foreach ($products as $product) {
        $stmt->execute($product);
    }

    echo "<p>✅ Database seeded with 8 hardware items.</p>";
    echo "<a href='index.php' style='display:inline-block; padding:10px 20px; background:#FE7743; color:white; text-decoration:none; border-radius:5px;'>Go to Home Page</a>";

} catch (Exception $e) {
    echo "<h1>❌ Error</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}

echo "Successfully seeded " . count($products) . " hardware items with stable Unsplash images!";
