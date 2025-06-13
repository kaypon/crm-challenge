# 📂 PHP CRM Challenge – Kevin van der Poll

A lightweight web-based customer relationship management (CRM) system built for the code assessment.  
Includes CSV import, data validation, loyalty point calculation, and a simple dashboard/report UI.

---

## 🚀 Features

- CSV import for `customers.csv` and `purchase_history.csv`
- Data validation and normalization
- MySQL database with foreign key relations
- Loyalty points logic:
  - +1 point per $10 spent
  - +10 bonus points per 10 purchases
  - Only purchases after Jan 1, 2022
- Dashboard view with customer stats
- Monthly report showing spend + points per month
- No Docker, no frameworks — just raw PHP + PDO

---

## 🛠 Getting Started

### 1. Clone the repo

```bash
git clone https://github.com/kaypon/crm-challenge.git
cd crm-challenge
```

### 2. Set up the environment

Install PHP & MySQL if not already installed:

```bash
sudo apt install php php-mysql mysql-server
```

### 3. Create the database

```bash
sudo mysql -u root -p
```

Inside MySQL:

```sql
CREATE DATABASE crm;
CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON crm.* TO 'user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Create tables

```bash
php src/setup_tables.php
```

### 5. Import data

```bash
php src/import_customers.php
php src/import_purchases.php
php src/calculate_loyalty.php
```

### 6. Start the server

```bash
cd public
php -S localhost:8080
```

Visit [http://localhost:8080](http://localhost:8080)

---

## 🧭 Routes

| URL                        | Description              |
|----------------------------|--------------------------|
| `/index.php`               | Portal / route selector  |
| `/dashboard.php`           | Customer dashboard       |
| `/report.php`              | Monthly reporting view   |

---

## 📁 Folder Structure

```
crm-challenge/
├── data/                   # CSV files
├── public/                 # Route endpoints
│   ├── index.php
│   ├── dashboard.php
│   └── report.php
├── src/                    # Business logic
│   ├── db.php
│   ├── functions.php
│   ├── setup_tables.php
│   ├── import_customers.php
│   ├── import_purchases.php
│   └── calculate_loyalty.php
└── README.md
```
