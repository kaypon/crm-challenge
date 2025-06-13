<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$file = __DIR__ . '/../data/customers.csv';
$handle = fopen($file, 'r');

if (!$handle) {
    die("❌ Unable to open customers.csv");
}

$header = fgetcsv($handle); // Skip CSV header row
$count = 0;

while (($row = fgetcsv($handle)) !== false) {
    // Map row to expected keys
    $customer = array_combine(['name', 'email', 'phone_number'], $row);

    // Validate & normalize
    if (!isValidCustomer($customer)) {
        echo "❌ Invalid customer: " . json_encode($customer) . "\n";
        continue;
    }

    $customer = formatCustomer($customer);
    $customer['created_at'] = date('Y-m-d');

    // Insert into DB
    try {
        $stmt = $pdo->prepare("INSERT INTO customers (name, email, phone_number, created_at)
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $customer['name'],
            $customer['email'],
            $customer['phone_number'],
            $customer['created_at']
        ]);
        $count++;
    } catch (PDOException $e) {
        echo "❌ Error inserting customer: " . $e->getMessage() . "\n";
    }
}

fclose($handle);
echo "✅ Imported $count customers.\n";
