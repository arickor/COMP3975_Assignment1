<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /login/index.php");
    $_SESSION['authorization_error'] = 'Please login to view the page';
    exit;
}

// Include your database connection file and your Transaction class
require_once("../../transaction/transaction.php");

// Get the date and shopName from the GET parameters
$date = isset($_GET['date']) ? $_GET['date'] : null;
$shopName = isset($_GET['shopName']) ? urldecode($_GET['shopName']) : null;

include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

// Prepare an SQL statement
$stmt = $db->prepare("SELECT * FROM Transactions WHERE Date = ? AND ShopName = ?");
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

// Extract the transaction details
$dateValue = $transaction['Date'];
$shopNameValue = $transaction['ShopName'];
$moneySpentValue = $transaction['MoneySpent'];
$moneyDepositedValue = $transaction['MoneyDeposited'];
$bankBalanceValue = $transaction['BankBalance'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Transaction</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Include jQuery UI library -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="text-center">Update Transaction</h1>
                <form action="process_update.php" method="post">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" id="date" name="date" class="form-control" value="<?php echo date('m/d/Y', strtotime($dateValue)); ?>" readonly>
                    </div>

                    <script>
                        jQuery(function() {
                            jQuery("#date").datepicker({
                                dateFormat: "mm/dd/yy"
                            });
                        });
                    </script>
                    <div class="form-group">
                        <label for="shopName">Shop Name</label>
                        <input type="text" id="shopName" name="shopName" class="form-control" value="<?php echo $shopNameValue; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="moneySpent">Money Spent</label>
                        <input type="number" id="moneySpent" name="moneySpent" class="form-control" value="<?php echo $moneySpentValue; ?>">
                    </div>
                    <div class="form-group">
                        <label for="moneyDeposited">Money Deposited</label>
                        <input type="number" id="moneyDeposited" name="moneyDeposited" class="form-control" value="<?php echo $moneyDepositedValue; ?>">
                    </div>
                    <div class="form-group">
                        <label for="bankBalance">Bank Balance</label>
                        <input type="number" id="bankBalance" name="bankBalance" class="form-control" value="<?php echo $bankBalanceValue; ?>">
                    </div>
                    <div class="form-group">
                        <a href="../../index.php" class="btn btn-small btn-primary">&lt;&lt; Back</a>
                        <button type="submit" name="update" class="btn btn-warning float-right">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>