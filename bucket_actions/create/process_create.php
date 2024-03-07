<?php
session_start();
// Check if the user is logged in, if not then redirect to login page
if ($_SESSION["loggedin"] !== true) {
    header("location: /login/index.php");
    exit;
}

if (isset($_POST['create'])) {
    require_once("../../buckets/buckets.php");
    require_once("../../transaction/transaction.php");

    extract($_POST);

    // Get the values from the form
    $category = $_POST['category'];
    $shopName = $_POST['shopName'];

    // Check if both Category and ShopName are empty
    if (empty($category) || empty($shopName)) {
        // Redirect back to the form with an error message
        $_SESSION['error_message'] = 'Please provide both Category and Shop Name.';
        header('Location: create.php');
        exit;
    }

    // Add the new bucket
    $result = Buckets::addBucket($category, $shopName);
    Transaction::removeUncategorizedShopName($shopName);

    

    if (isset($result['error'])) {
        header('Location: create.php?error=' . urlencode($result['error']));
        exit;
    }

    header('Location: /admin/manage_bucket.php');
}