<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/db.php';

// fetch all customers, sorted by loyalty
$stmt = $pdo->query("SELECT * FROM customers ORDER BY loyalty_points DESC");
$customers = $stmt->fetchAll();

// basic stats
$totalCustomers = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$avgSpend = $pdo->query("
    SELECT AVG(total_spent) FROM (
        SELECT SUM(total) AS total_spent FROM purchase_history GROUP BY customer_id
    ) AS totals
")->fetchColumn();

$topSpender = $pdo->query("
    SELECT c.email, SUM(p.total) AS total_spent, COUNT(*) AS purchase_count
    FROM customers c
    JOIN purchase_history p ON c.id = p.customer_id
    GROUP BY c.email
    ORDER BY total_spent DESC
    LIMIT 1
")->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; padding: 2rem; }
        .stats { display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
        .card {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            flex: 1 1 200px;
        }
        table {
            width: 100%; background: white;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 0.75rem;
            border-bottom: 1px solid #eee;
        }
        th { background: #222; color: white; }
        .back {
            display: inline-block;
            margin-bottom: 1rem;
            background: #444;
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <a href="index.php" class="back">← Back</a>
    <h1>📊 Customer Dashboard</h1>

    <div class="stats">
        <div class="card"><strong>Total Customers:</strong><br><?= $totalCustomers ?></div>
        <div class="card"><strong>Avg Spend:</strong><br>$<?= number_format($avgSpend, 2) ?></div>
        <div class="card"><strong>Top Spender:</strong><br><?= htmlspecialchars($topSpender['email']) ?><br>
            <small>$<?= number_format($topSpender['total_spent'], 2) ?> / <?= $topSpender['purchase_count'] ?> purchases</small>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Phone</th><th>Joined</th><th>Points</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['name']) ?></td>
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= htmlspecialchars($c['phone_number']) ?></td>
                    <td><?= $c['created_at'] ?></td>
                    <td><?= $c['loyalty_points'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
