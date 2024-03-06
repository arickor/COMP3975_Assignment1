<?php

// Check if the user is logged in, if not then redirect to login page
if ($_SESSION["loggedin"] !== true) {
    header("location: /login/index.php");
    exit;
}

if (isset($_POST['create'])) {
    require_once("../../transaction/transaction.php");

    extract($_POST);

    // Get the values from the form and convert them to float
    $moneySpent = empty($_POST['moneySpent']) ? 0 : floatval($_POST['moneySpent']);
    $moneyDeposited = empty($_POST['moneyDeposited']) ? 0 : floatval($_POST['moneyDeposited']);

    // Fetch the latest bank balance from the database
    $bankBalance = Transaction::getLatestBankBalance();

    // Check if both MoneySpent and MoneyDeposited are empty
    if ($moneySpent == 0 && $moneyDeposited == 0) {
        // Redirect back to the form with an error message
        $_SESSION['error_message'] = 'Please provide either Money Spent or Money Deposited.';
        header('Location: create.php');
        exit;
    }

    // Calculate the new bank balance
    if (!empty($moneySpent)) {
        $bankBalance -= $moneySpent;
    }
    if (!empty($moneyDeposited)) {
        $bankBalance += $moneyDeposited;
    }

    $tableName = "Transactions";

    Transaction::addTransaction($date, $shopName, $moneySpent, $moneyDeposited, $bankBalance);
    Transaction::addUncategorizedShopName($shopName);
    if (isset($result['error'])) {
        header('Location: create.php?error=' . urlencode($result['error']));
        exit;
    }

    header('Location: ../../index.php');
}