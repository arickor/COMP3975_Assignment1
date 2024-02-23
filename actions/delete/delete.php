<h1>Delete Transaction</h1>

<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

if (isset($_GET['date']) && isset($_GET['shopName'])) {

    $date = $_GET['date'];
    $shopName = $_GET['shopName'];

    $version = $db->querySingle('SELECT SQLITE_VERSION()');

    $checkDuplicateQuery = "SELECT COUNT(*) AS 'rowCount' FROM Transactions WHERE Date =? AND ShopName = ?";
    $checkStmt = $db->prepare($checkDuplicateQuery);
    $checkStmt->bindParam(1, $date, SQLITE3_TEXT);
    $checkStmt->bindParam(2, $shopName, SQLITE3_TEXT);
    $result = $checkStmt->execute();
    $rowCount = $result->fetchArray(SQLITE3_NUM);
    $rowCount = $rowCount[0];


    if ($rowCount == 0) {
        // The specified ID doesn't exist in the database
        // echo "<p class='alert alert-danger'>Transaction with ID $id does not exist.</p>";
        echo "<a href='../../index.php' class='btn btn-small btn-primary'>&lt;&lt; BACK</a>";
        exit;
    }

    $fetchQuery = "SELECT * FROM Transactions WHERE Date = ? AND ShopName = ?";
    $fetchStmt = $db->prepare($fetchQuery);
    $fetchStmt->bindParam(1, $date, SQLITE3_TEXT);
    $fetchStmt->bindParam(2, $shopName, SQLITE3_TEXT);
    $result = $fetchStmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);

    // Assign values to variables
    $date = $row['Date'];
    $shopName = $row['ShopName'];
    $moneySpent = $row['MoneySpent'];
    $moneyDeposited = $row['MoneyDeposited'];
    $bankBalance = $row['BankBalance'];
};

$db->close();
?>

<table>
    <tr>
        <td>Date: </td>
        <td><?php echo $date ?></td>
    </tr>
    <tr>
        <td>Shop Name: </td>
        <td><?php echo $shopName ?></td>
    </tr>
    <tr>
        <td>Money Spent: </td>
        <td><?php echo $moneySpent ?></td>
    </tr>
    <tr>
        <td>Money Deposited: </td>
        <td><?php echo $moneyDeposited ?></td>
    </tr>
    <tr>
        <td>Bank Balance: </td>
        <td><?php echo $bankBalance ?></td>
    </tr>
</table>
<br />
<form action="process_delete.php" method="post">
    <input type="hidden" value="<?php echo $date ?>" name="date" />
    <input type="hidden" value="<?php echo $shopName ?>" name="shopName" />
    <a href="../../index.php" class="btn btn-small btn-primary">&lt;&lt; BACK</a>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Delete" class="btn btn-danger" name="delete" />
</form>

<br />