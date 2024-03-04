<?php


class Transaction
{
    public static function showTransactionTable()
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $resultSet = $db->query('SELECT * FROM Transactions');

        echo "<div class='container mt-5'>";
        echo "<p><a class='btn btn-success mb-3' href='/actions/create/create.php'>Create New</a></p>";

        echo "<table class='table table-striped table-bordered table-hover'>\n";
        echo "<thead class='thead-dark'>";
        echo "<tr><th scope='col'>Date</th>
        <th scope='col'>ShopName</th>
        <th scope='col'>MoneySpent</th>
        <th scope='col'>MoneyDeposited</th>
        <th scope='col'>BankBalance</th>
        <th scope='col'>Actions</th>
        </tr>\n";
        echo "</thead><tbody>";

        while ($row = $resultSet->fetchArray()) {
            echo "<tr><td>{$row[0]}</td>";
            echo "<td>{$row[1]}</td>";
            echo "<td>{$row[2]}</td>";
            echo "<td>{$row[3]}</td>";
            echo "<td>{$row[4]}</td>";
            echo "<td>";
            echo "<a class='btn btn-warning' href='/actions/update/update.php?date={$row[0]}&shopName={$row[1]}'>Update</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-danger' href='/actions/delete/delete.php?date={$row[0]}&shopName={$row[1]}'>Delete</a>";
            echo "</td></tr>\n";
        }
        echo "</tbody></table>\n";
        echo "</div>";

        $db->close();
    }

    public static function addTransaction($date, $shopName, $moneySpent, $moneyDeposited, $bankBalance)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        // Prepare an SQL statement
        $stmt = $db->prepare("INSERT INTO Transactions (Date, ShopName, MoneySpent, MoneyDeposited, BankBalance) VALUES (?, ?, ?, ?, ?)");

        // Bind parameters to the SQL statement
        $stmt = $db->prepare("INSERT INTO Transactions (Date, ShopName, MoneySpent, MoneyDeposited, BankBalance) VALUES (?, ?, ?, ?, ?)");

        $stmt->bindValue(1, $date);
        $stmt->bindValue(2, $shopName);
        $stmt->bindValue(3, $moneySpent);
        $stmt->bindValue(4, $moneyDeposited);
        $stmt->bindValue(5, $bankBalance);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            // Handle the error
            echo "Error: " . $e->getMessage();
        }

        // Close the database connection
        $db->close();
    }

    public static function deleteTransaction($date, $shopName)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        // Prepare an SQL statement
        $stmt = $db->prepare("DELETE FROM Transactions WHERE Date = ? AND ShopName = ?");

        // Bind parameters to the SQL statement
        $stmt->bindValue(1, $date);
        $stmt->bindValue(2, $shopName);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            // Handle the error
            return ['error' => $e->getMessage()];
        }

        // Close the database connection
        $db->close();

        return ['success' => true];
    }
}
