<?php

require_once __DIR__ . '/../app/functions.php';

requireAdmin();

$stmt = getDbConnection()->query(
    'SELECT o.*, p.name AS product_name, p.image_url
     FROM orders o
     INNER JOIN products p ON p.id = o.product_id
     ORDER BY o.created_at DESC'
);
$orders = $stmt->fetchAll();
$statuses = getOrderStatuses();

$pageTitle = 'Admin Orders';
require_once __DIR__ . '/../app/header.php';
?>
<div class="bg-slate-50 min-h-screen">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12 reveal-on-scroll">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-accent mb-2 block">Command Center</span>
                <h1 class="text-3xl font-bold font-heading text-navy">Order Fulfillment</h1>
                <p class="text-slate-500 text-sm mt-1">Review customer acquisitions and manage logistic status updates.</p>
            </div>
            <div class="flex gap-4">
                <a href="<?= BASE_URL; ?>/admin_products.php" class="bg-white text-navy px-6 py-3 rounded-xl text-xs font-bold border border-slate-100 shadow-sm hover:shadow-md transition-all no-underline flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    Inventory Control
                </a>
            </div>
        </div>

        <?php if (!$orders): ?>
            <div class="bg-white p-24 rounded-[40px] text-center border border-slate-100 shadow-sm reveal-on-scroll">
                <div class="text-5xl mb-6">📉</div>
                <h3 class="text-2xl font-bold text-navy mb-2">Marketplace Static</h3>
                <p class="text-slate-500 text-sm max-w-sm mx-auto">No orders recorded in the current session. Activity will broadcast here in real-time.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <?php foreach ($orders as $order): ?>
                     <article class="bg-white p-8 md:p-10 rounded-[40px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all reveal-on-scroll">
                        <div class="flex flex-col md:flex-row gap-8">
                            <!-- Left: Product & Basic Info -->
                            <div class="md:w-48 shrink-0">
                                <div class="aspect-square bg-slate-50 rounded-[32px] flex items-center justify-center p-6 overflow-hidden mb-6">
                                    <img src="<?= e($order['image_url']); ?>" alt="<?= e($order['product_name']); ?>" class="w-full h-full object-contain drop-shadow-xl">
                                </div>
                                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                                    <div class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Status</div>
                                    <div class="flex items-center gap-2">
                                        <?php 
                                            $dotColor = match(strtolower($order['status'])) {
                                                'pending' => 'bg-amber-400',
                                                'processing' => 'bg-blue-500',
                                                'shipped' => 'bg-purple-500',
                                                'delivered' => 'bg-green-500',
                                                'cancelled' => 'bg-rose-500',
                                                default => 'bg-slate-400'
                                            };
                                        ?>
                                        <span class="w-2 h-2 rounded-full <?= $dotColor; ?> animate-pulse"></span>
                                        <span class="text-xs font-bold text-navy uppercase tracking-wider"><?= e($order['status']); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Middle: Customer Details -->
                            <div class="flex-1 min-w-0">
                                <div class="mb-8">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-accent bg-accent/5 px-2 py-0.5 rounded-full">Order #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></span>
                                        <span class="text-[10px] font-bold text-slate-400"><?= date('M d, Y • H:i', strtotime($order['created_at'])); ?></span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-navy truncate"><?= e($order['product_name']); ?></h3>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8">
                                    <div class="space-y-4">
                                        <div>
                                            <div class="text-[10px] font-bold tracking-[0.2em] uppercase text-slate-400 mb-1">Acquirer</div>
                                            <div class="text-sm font-bold text-navy"><?= e($order['customer_name']); ?></div>
                                            <div class="text-[11px] text-slate-500 mt-0.5"><?= e($order['customer_email']); ?></div>
                                        </div>
                                        <div>
                                            <div class="text-[10px] font-bold tracking-[0.2em] uppercase text-slate-400 mb-1">Contact Protocol</div>
                                            <div class="text-sm font-bold text-navy"><?= e($order['phone']); ?></div>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <div class="text-[10px] font-bold tracking-[0.2em] uppercase text-slate-400 mb-1">Destination node</div>
                                            <div class="text-[11px] text-slate-500 font-semibold leading-relaxed"><?= e($order['address']); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="pt-8 border-t border-slate-50 flex flex-col sm:flex-row items-end sm:items-center justify-between gap-6">
                                    <div>
                                        <div class="text-[10px] font-bold uppercase text-slate-400 mb-1">Net Allocation</div>
                                        <div class="text-2xl font-bold text-navy">Rs. <?= number_format((float) $order['total_amount'], 2); ?> <span class="text-xs text-slate-400 font-medium">/ <?= (int) $order['quantity']; ?> qty</span></div>
                                    </div>

                                    <form method="post" action="<?= BASE_URL; ?>/update_order_status.php" class="flex gap-2">
                                        <input type="hidden" name="order_id" value="<?= (int) $order['id']; ?>">
                                        <select name="status" required class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-[10px] font-bold uppercase tracking-wider text-navy outline-none">
                                            <?php foreach ($statuses as $status): ?>
                                                <option value="<?= e($status); ?>" <?= $order['status'] === $status ? 'selected' : ''; ?>>
                                                    <?= e($status); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="bg-navy text-white p-3 rounded-xl hover:bg-accent transition-all shadow-lg shadow-navy/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../app/footer.php'; ?>
