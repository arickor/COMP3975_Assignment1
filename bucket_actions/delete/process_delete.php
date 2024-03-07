<?php
require '../../initialize.php';

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