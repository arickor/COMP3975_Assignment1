<?php

include 'include_db.php';

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

$db->close();
