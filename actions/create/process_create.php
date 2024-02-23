<?php

if (isset($_POST['create'])) {
    require_once("../../transaction/transaction.php");

    extract($_POST);

    $tableName = "Transactions";

    Transaction::addTransaction($date, $shopName, $moneySpent, $moneyDeposited, $bankBalance);

    if (isset($result['error'])) {
        header('Location: create.php?error=' . urlencode($result['error']));
        exit;
    }

    header('Location: ../../index.php');
    exit;
}
