<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/db.php';

// group purchases by month, calculate avg spend + total points
$stmt = $pdo->query("
    SELECT
        DATE_FORMAT(p.purchase_date, '%Y-%m') AS month,
        SUM(p.total) / COUNT(DISTINCT p.customer_id) AS avg_spend,
        SUM(FLOOR(p.total / 10)) + (FLOOR(COUNT(p.id) / 10)) AS total_points
    FROM purchase_history p
    WHERE p.purchase_date >= '2022-01-01'
    GROUP BY month
    ORDER BY month ASC
");
$report = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monthly Report</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 2rem; }
        table {
            background: white;
            border-collapse: collapse;
            width: 100%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 0.75rem;
            border: 1px solid #ddd;
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
    <h1>📈 Monthly Report</h1>
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Avg Spend / Customer</th>
                <th>Total Points Awarded</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $row): ?>
                <tr>
                    <td><?= $row['month'] ?></td>
                    <td>$<?= number_format($row['avg_spend'], 2) ?></td>
                    <td><?= $row['total_points'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
