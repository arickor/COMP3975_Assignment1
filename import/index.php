<?php

include '../include_db.php';

$result = $db->query("SELECT COUNT(*) as count FROM Transactions");
$row = $result->fetchArray();
$count = $row['count'];

if ($count == 0) {
    $file = fopen('../2023 02.csv', 'r');

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
}

$db->close();

?>
