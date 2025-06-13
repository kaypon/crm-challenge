<?php
require_once __DIR__ . '/db.php';

// Drop existing tables if they exist to reset the DB
$queries = [
    "DROP TABLE IF EXISTS purchase_history",
    "DROP TABLE IF EXISTS customers",

    // Create customers table
    "CREATE TABLE customers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        phone_number VARCHAR(20),
        created_at DATE,
        loyalty_points INT DEFAULT 0
    )",

    // Create purchase_history table with FK to customers
    "CREATE TABLE purchase_history (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_id INT NOT NULL,
        purchasable VARCHAR(255),
        price DECIMAL(10,2),
        quantity INT,
        total DECIMAL(10,2),
        purchase_date DATE,
        FOREIGN KEY (customer_id) REFERENCES customers(id)
    )"
];

// Run each SQL statement
foreach ($queries as $sql) {
    $pdo->exec($sql);
}

echo "✅ Tables created successfully.\n";
