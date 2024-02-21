<?php

$db = new SQLite3('expenses.sqlite');

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

$file = fopen('2023 02.csv', 'r');

while (($line = fgetcsv($file)) !== FALSE) {
    $date = SQLite3::escapeString($line[0]);
    $shopName = SQLite3::escapeString($line[1]);
    $moneySpent = SQLite3::escapeString($line[2]);
    $moneyDeposited = SQLite3::escapeString($line[3]);
    $bankBalance = SQLite3::escapeString($line[4]);

    $SQL_insert = "INSERT INTO Transactions (Date, ShopName, MoneySpent, MoneyDeposited, BankBalance) 
                 VALUES ('$date', '$shopName', '$moneySpent', '$moneyDeposited', '$bankBalance');";
    $db->exec($SQL_insert);
}

fclose($file);

$db->close();
