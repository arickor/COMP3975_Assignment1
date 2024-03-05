
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

$SQL_create_table .= "CREATE TABLE IF NOT EXISTS Buckets (
    Category VARCHAR(100) NOT NULL,
    ShopName VARCHAR(100) NOT NULL,
    PRIMARY KEY (ShopName),
    FOREIGN KEY (ShopName) REFERENCES Transactions(ShopName)
);";

$SQL_create_table .= "CREATE TABLE IF NOT EXISTS Users (
    Email VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    IsApproved BOOLEAN DEFAULT FALSE,
    IsAdmin BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (Email)
);";

$db->exec($SQL_create_table);



// Check if the Buckets table is empty
$SQL_check_buckets = "SELECT COUNT(*) FROM Buckets";
$result = $db->querySingle($SQL_check_buckets);

// If the Buckets table is empty, insert the data
if ($result == 0) {
    $SQL_insert_buckets = "INSERT INTO Buckets (Category, ShopName) VALUES 
    ('Entertainment', 'ST JAMES RESTAURAT'), ('Donation', 'RED CROSS'), ('Groceries', 'SAFEWAY'),
    ('Insurance', 'GATEWAY'), ('Groceries', 'PUR & SIMPLE RESTAUR'), ('Dining', 'subway'),
    ('Groceries', 'REAL CDN SUPERS'), ('Insurance', 'ICBC'), 
    ('Utility', 'FORTISBC GAS'), ('Bank', 'BMO'), 
    ('Groceries', 'WALMART STORE'), ('Groceries', 'COSTCO WHOLESAL'), 
    ('Dining', 'MCDONALDS'), ('Dining', 'WHITE SPOT RESTAURAN'), ('Utility', 'SHAW CABLE'), 
    ('Utility', 'CANADIAN TIRE'), ('Donation', 'World Vision'), ('Snack', 'TIM HORTONS'), 
    ('Snack', '7-ELEVEN STORE'), ('Bank', 'CHQ'), ('Utility', 'ROGERS MOBILE'),
    ('Bank', 'O.D.P'), ('Bank', 'MONTHLY ACCOUNT FEE')";
    $db->exec($SQL_insert_buckets);
}

$db->close();
