<?php
require_once __DIR__ . '/db.php';

$file = __DIR__ . '/../data/purchase_history.csv';
$handle = fopen($file, 'r');

if (!$handle) {
    die("❌ Unable to open purchase_history.csv");
}

$header = fgetcsv($handle); // Skip header

$count = 0;
while (($row = fgetcsv($handle)) !== false) {
    [$email, $purchasable, $price, $quantity, $total, $date] = $row;

    // Get matching customer ID
    $stmt = $pdo->prepare("SELECT id FROM customers WHERE email = ?");
    $stmt->execute([strtolower($email)]);
    $customer = $stmt->fetch();

    if (!$customer) {
        echo "❌ No match for email: $email\n";
        continue;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO purchase_history
            (customer_id, purchasable, price, quantity, total, purchase_date)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $customer['id'],
            $purchasable,
            $price,
            $quantity,
            $total,
            $date
        ]);
        $count++;
    } catch (PDOException $e) {
        echo "❌ Error inserting purchase: " . $e->getMessage() . "\n";
    }
}

fclose($handle);
echo "✅ Imported $count purchases.\n";
