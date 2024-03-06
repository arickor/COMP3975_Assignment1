<?php

if (isset($_POST['update'])) {
    require_once("../../buckets/buckets.php");

    $shopName = $_POST['shopName'];
    $category = $_POST['category'];

    // Call the updateBucket method
    $result = Buckets::updateBucket($shopName, $category);

    if (isset($result['error'])) {
        // The updateBucket method returned an error, redirect to the update page with the error message
        header('Location: update.php?shopName=' . urlencode($shopName) . '&error=' . urlencode($result['error']));
        exit;
    }

    // The updateBucket method was successful, redirect to the index page
    header('Location: /admin/manage_bucket.php');
    exit;
}