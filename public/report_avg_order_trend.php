<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/db.php';

// Fetch last 12 months of avg order value
$sql = "
  SELECT
    DATE_FORMAT(purchase_date, '%Y-%m') AS month,
    AVG(total)                       AS avg_order
  FROM purchase_history
  WHERE purchase_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
  GROUP BY month
  ORDER BY month
";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();

// Prepare data for Chart.js
$months    = array_column($rows, 'month');
$avgOrders = array_map(fn($r) => round($r['avg_order'], 2), $rows);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Avg Order Value Trend</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: sans-serif; padding: 2rem; }
    canvas { max-width: 800px; margin: auto; }
    h1 { text-align: center; }
  </style>
</head>
<body>
  <h1>📈 Monthly Avg. Order Value (Last 12 Months)</h1>
  <canvas id="avgOrderChart"></canvas>

  <script>
    const ctx = document.getElementById('avgOrderChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
          label: 'Avg Order Value ($)',
          data: <?= json_encode($avgOrders) ?>,
          fill: false,
          tension: 0.2
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false,
            ticks: {
              callback: value => '$' + value
            }
          }
        },
        responsive: true,
        plugins: {
          legend: { position: 'top' }
        }
      }
    });
  </script>
</body>
</html>
