<?php
require_once __DIR__ . '/db.php';

// Only consider purchases from this date forward
$cutoff = '2022-01-01';

// Fetch all customers
$stmt = $pdo->query("SELECT id, name FROM customers");
$customers = $stmt->fetchAll();

$totalUpdated = 0;

foreach ($customers as $customer) {
    $id = $customer['id'];

    // Get total spent and number of purchases for this customer after cutoff
    $stmt = $pdo->prepare("
        SELECT SUM(total) AS total_spent, COUNT(*) AS purchase_count
        FROM purchase_history
        WHERE customer_id = ? AND purchase_date >= ?
    ");
    $stmt->execute([$id, $cutoff]);
    $stats = $stmt->fetch();

    $spent = floatval($stats['total_spent'] ?? 0);
    $count = intval($stats['purchase_count'] ?? 0);

    // Loyalty formula: 1 point per $10 + 10 bonus per 10 purchases
    $points = floor($spent / 10) + (floor($count / 10) * 10);

    // Update points in the DB
    $update = $pdo->prepare("UPDATE customers SET loyalty_points = ? WHERE id = ?");
    $update->execute([$points, $id]);

    echo "🟢 {$customer['name']} — \${$spent} spent / {$count} purchases → {$points} points\n";
    $totalUpdated++;
}

echo "\n✅ Loyalty points updated for $totalUpdated customers.\n";
