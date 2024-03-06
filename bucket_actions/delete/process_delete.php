<?php

// Check if the user is logged in, if not then redirect to login page
if ($_SESSION["loggedin"] !== true) {
    header("location: /login/index.php");
    exit;
}

if (isset($_POST['delete'])) {
    require_once("../../buckets/buckets.php");

    $shopName = $_POST['shopName'];

    $result = Buckets::deleteBucket($shopName);

    if (isset($result['error'])) {
        header('Location: delete.php?error=' . urlencode($result['error']));
        exit;
    }

    header('Location: /admin/manage_bucket.php');
    exit;
}