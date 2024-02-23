<?php

if (isset($_POST['delete'])) {
    require_once("../../transaction/transaction.php");

    $date = $_POST['date'];
    $shopName = $_POST['shopName'];

    $result = Transaction::deleteTransaction($date, $shopName);

    if (isset($result['error'])) {
        header('Location: delete.php?error=' . urlencode($result['error']));
        exit;
    }

    header('Location: ../../index.php');
    exit;
}
