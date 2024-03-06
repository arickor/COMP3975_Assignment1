<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

$SQL_create_table = "CREATE TABLE IF NOT EXISTS Transactions (
    Date DATE NOT NULL,
    ShopName VARCHAR(100),
    MoneySpent DECIMAL(10, 2),
    MoneyDeposited DECIMAL(10, 2),
    BankBalance DECIMAL(10, 2),
    PRIMARY KEY (Date, ShopName)
);";

$SQL_create_table .= "CREATE TABLE IF NOT EXISTS Users (
    Email VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    IsApproved BOOLEAN DEFAULT FALSE,
    IsAdmin BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (Email)
);";

$SQL_create_table .= "CREATE TABLE IF NOT EXISTS UncategorizedShops (
    ShopName varchar(255) PRIMARY KEY
)";

$db->exec($SQL_create_table);

// // Drop the Buckets table
// $SQL_drop_buckets = "DROP TABLE IF EXISTS Buckets";
// $db->exec($SQL_drop_buckets);

// Create the Buckets table without foreign key constraint
$SQL_create_buckets = "CREATE TABLE Buckets (
    Category VARCHAR(100) NOT NULL,
    ShopName VARCHAR(100) NOT NULL,
    PRIMARY KEY (ShopName)
)";
$db->exec($SQL_create_buckets);

// Insert data into the Buckets table
$SQL_insert_buckets = "INSERT INTO Buckets (Category, ShopName) VALUES 
('Entertainment', 'ST JAMES RESTAURAT'), ('Donation', 'RED CROSS'), ('Groceries', 'SAFEWAY'),
('Insurance', 'GATEWAY          MSP'), ('Dining', 'PUR & SIMPLE RESTAUR'), ('Dining', 'Subway'),
('Groceries', 'REAL CDN SUPERS'), ('Insurance', 'ICBC             INS'), 
('Utility', 'FORTISBC GAS'), ('Bank', 'BMO'), 
('Groceries', 'WALMART STORE'), ('Groceries', 'COSTCO WHOLESAL'), 
('Dining', 'MCDONALDS'), ('Dining', 'WHITE SPOT RESTAURAN'), ('Utility', 'SHAW CABLE'), 
('Utility', 'CANADIAN TIRE'), ('Donation', 'World Vision     MSP'), ('Dining', 'TIM HORTONS'), 
('Groceries', '7-ELEVEN STORE'), ('Bank', 'CHQ'), ('Utility', 'ROGERS MOBILE'), ('Insurance', 'ICBC'), 
('Bank', 'O.D.P'), ('Bank', 'MONTHLY ACCOUNT FEE')";
$db->exec($SQL_insert_buckets);

$db->close();