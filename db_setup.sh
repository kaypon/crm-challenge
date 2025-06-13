#!/bin/bash

echo "🔐 Enter your MySQL root password when prompted..."

# Step 1: Reset the database
mysql -u root -p <<EOF
DROP DATABASE IF EXISTS crm;
DROP USER IF EXISTS 'user'@'localhost';
CREATE DATABASE crm;
CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON crm.* TO 'user'@'localhost';
FLUSH PRIVILEGES;
EOF

# Step 2: Rebuild tables and import data
echo "📦 Rebuilding tables and importing data..."

php src/setup_tables.php
php src/import_customers.php
php src/import_purchases.php
php src/calculate_loyalty.php

echo "✅ Fresh install complete. Visit http://localhost:8080 to view the CRM."
