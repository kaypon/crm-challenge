<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CRM Portal</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        a {
            text-decoration: none;
            color: white;
            background: #333;
            padding: 1rem 2rem;
            border-radius: 8px;
            margin: 0.5rem;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>📂 CRM Portal</h1>
    <a href="dashboard.php">📊 View Dashboard</a>
    <a href="report.php">📈 View Monthly Report</a>
    <a href="report_avg_order_trend.php">📊 Avg Order Trend</a>

</body>
</html>
