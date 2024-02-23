<?php


class Transaction
{
    public static function showTransactionTable()
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $resultSet = $db->query('SELECT * FROM Transactions');

        echo "<div class='container'>";
        echo "<p><a class='btn btn-success' href='/actions/create/create.php'>Create New</a></p>";

        echo "<table class='table table-hover'>\n";
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
            echo "<a class='btn btn-primary' href='/actions/display/display.php?id={$row[0]}'>Display</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-warning' href='/actions/update/update.php?id={$row[0]}'>Update</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-danger' href='/actions/delete/delete.php?id={$row[0]}'>Delete</a>";
            echo "</td></tr>\n";
        }
        echo "</tbody></table>\n";
        echo "</div>";

        $db->close();
    }

    public static function addTransaction()
    {
        // Code to add a transaction
    }
}

?>