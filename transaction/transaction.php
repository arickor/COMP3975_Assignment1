<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if ($_SESSION["loggedin"] !== true) {
    header("location: /login/index.php");
    exit;
}

class Transaction
{
    public static function showTransactionTable()
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $resultSet = $db->query('SELECT * FROM Transactions');

        echo "<div class='container mt-5'>";
        echo "<div class='row'>";
        echo "<div class='col-md-8'>";
        echo "<p><a class='btn btn-success mb-1' href='/actions/create/create.php'>Create New</a>";
        echo "<a class='btn btn-success mb-1 ml-2' href='/import/import.php'>Import</a></p>";
        echo "</div>";
        echo "<div class='col-md-4 text-right'>";
        echo "<p><a class='btn btn-info mb-1' href='/report/index.php'>Report</a></p>";
        echo "</div>";
        echo "</div>";

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
            echo "<a class='btn btn-warning' href='/actions/update/update.php?date=" . urlencode($row[0]) . "&shopName=" . urlencode($row[1]) . "'>Update</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-danger' href='/actions/delete/delete.php?date=" . urlencode($row[0]) . "&shopName=" . urlencode($row[1]) . "'>Delete</a>";
            echo "</td></tr>\n";
        }
        echo "</tbody></table>\n";
        echo "</div>";

        $db->close();
    }

    public static function addUncategorizedShopName($shopName)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';
        $resultSet = $db->query("SELECT * FROM Buckets WHERE ShopName LIKE '%$shopName%'");

        if (!$resultSet->fetchArray()) {
            // The shop name is not in the Buckets table, add it to the UncategorizedShops table
            $db->exec("INSERT INTO UncategorizedShops (ShopName) VALUES ('$shopName')");
        }
    }

    public static function removeUncategorizedShopName($shopName)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';
        $db->exec("DELETE FROM UncategorizedShops WHERE ShopName LIKE '%$shopName%'");
    }

    public static function getLatestBankBalance()
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $resultSet = $db->query('SELECT BankBalance FROM Transactions');

        $rows = [];
        while ($row = $resultSet->fetchArray()) {
            $rows[] = $row;
        }

        $lastRow = end($rows);
        return $lastRow ? floatval($lastRow['BankBalance']) : 0;
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

    public static function getTransaction($date, $shopName)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        // Prepare an SQL statement
        $stmt = $db->prepare("SELECT * FROM Transactions WHERE Date = ? AND ShopName = ?");

        // Bind parameters to the SQL statement
        $stmt->bindValue(1, $date);
        $stmt->bindValue(2, $shopName);

        // Execute the SQL statement and fetch the result
        $result = $stmt->execute();
        $transaction = $result->fetchArray(SQLITE3_ASSOC);

        // Check if a transaction was found
        if ($transaction === false) {
            // No transaction was found, return an empty array
            $transaction = array();
        }

        // Close the database connection
        $db->close();

        return $transaction;
    }

    public static function updateTransaction($date, $shopName, $moneySpent, $moneyDeposited, $bankBalance)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        // Prepare an SQL statement
        $stmt = $db->prepare("UPDATE Transactions SET MoneySpent = ?, MoneyDeposited = ?, BankBalance = ? WHERE Date = ? AND ShopName = ?");

        // Bind parameters to the SQL statement
        $stmt->bindValue(1, (float)$moneySpent);
        $stmt->bindValue(2, (float)$moneyDeposited);
        $stmt->bindValue(3, (float)$bankBalance);
        $stmt->bindValue(4, $date);
        $stmt->bindValue(5, $shopName);

        // Execute the SQL statement and check if it was successful
        if ($stmt->execute() === false) {
            // The SQL statement failed, return an error message
            return array('error' => 'Failed to update transaction');
        }

        // Close the database connection
        $db->close();

        // The SQL statement was successful, return an empty array
        return array();
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

    public static function showYearlyReport($year)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $resultSet = $db->query("SELECT 
                                (SELECT Category FROM Buckets WHERE Transactions.ShopName LIKE '%' || Buckets.ShopName || '%') as Category, 
                                SUM(Transactions.MoneySpent) as TotalSpent
                             FROM Transactions
                             WHERE substr(Date, 7) = '$year'
                             GROUP BY Category");

        echo "<div class='container mt-5'>";
        echo "<h1>Yearly Report for $year</h1>";
        echo "<div class='table-responsive'>";  // Add this line
        echo "<table class='table table-striped table-bordered table-hover'>\n";
        echo "<thead class='thead-dark'>";
        echo "<tr><th scope='col'>Category</th>
<th scope='col'>Total Spent</th>
</tr>\n";
        echo "</thead><tbody>";

        while ($row = $resultSet->fetchArray()) {
            if ($row['TotalSpent'] == 0) {
                continue;
            }
            echo "<tr><td>{$row['Category']}</td>";
            echo "<td>{$row['TotalSpent']}</td>";
            echo "</tr>\n";
        }
        echo "</tbody></table>\n";
        echo "</div>";  // Add this line
        echo "</div>";
        $db->close();
        return $resultSet;
    }

    public static function showYearlyChart($year)

    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $resultSet = $db->query("SELECT 
                                (SELECT Category FROM Buckets WHERE Transactions.ShopName LIKE '%' || Buckets.ShopName || '%') as Category, 
                                SUM(Transactions.MoneySpent) as TotalSpent
                             FROM Transactions
                             WHERE substr(Date, 7) = '$year'
                             GROUP BY Category");
        $data = [];
        while ($row = $resultSet->fetchArray()) {
            if ($row['TotalSpent'] == 0) {
                continue;
            }
            $data[] = ['category' => $row['Category'], 'totalSpent' => $row['TotalSpent']];
        } {
            include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

            $resultSet = $db->query("SELECT 
                                    (SELECT Category FROM Buckets WHERE Transactions.ShopName LIKE '%' || Buckets.ShopName || '%') as Category, 
                                    SUM(Transactions.MoneySpent) as TotalSpent
                                 FROM Transactions
                                 WHERE substr(Date, 7) = '$year'
                                 GROUP BY Category");
            $data = [];
            while ($row = $resultSet->fetchArray()) {
                if ($row['TotalSpent'] == 0) {
                    continue;
                }
                $data[] = ['category' => $row['Category'], 'totalSpent' => $row['TotalSpent']];
            }
            echo '<div style="display: flex; justify-content: center; align-items: center; height: 60vh;">
            <div style="display: flex; justify-content: center; align-items: center; width: 400px; height: 400px; border: 1px solid black; padding: 10px;">
            <canvas id="yearlyChart"></canvas>
            </div>
            </div>';

            echo "<script>
            var data = " . json_encode($data) . ";
            
            var ctx = document.getElementById('yearlyChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.map(function(item) { return item.category; }),
                    datasets: [{
                        data: data.map(function(item) { return item.totalSpent; }),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false
                }
            });
            </script>";
        }
        $db->close();
    }
}
