<?php
require '../../initialize.php';

if (isset($_POST['update'])) {
    require_once("../../transaction/transaction.php");

    $date = $_POST['date'];
    $shopName = $_POST['shopName'];
    $moneySpent = $_POST['moneySpent'];
    $moneyDeposited = $_POST['moneyDeposited'];
    $bankBalance = $_POST['bankBalance'];

    // Call the updateTransaction method
    $result = Transaction::updateTransaction($date, $shopName, $moneySpent, $moneyDeposited, $bankBalance);

    if (isset($result['error'])) {
        // The updateTransaction method returned an error, redirect to the update page with the error message
        header('Location: update.php?date=' . urlencode($date) . '&shopName=' . urlencode($shopName) . '&error=' . urlencode($result['error']));
        exit;
    }

    // The updateTransaction method was successful, redirect to the index page
    header('Location: ../../index.php');
    exit;
}
