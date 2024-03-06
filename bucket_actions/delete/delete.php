<h1>Delete Bucket</h1>

<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

if (isset($_GET['shopName'])) {

    $shopName = $_GET['shopName'];

    $version = $db->querySingle('SELECT SQLITE_VERSION()');

    $checkDuplicateQuery = "SELECT COUNT(*) AS 'rowCount' FROM Buckets WHERE ShopName = ?";
    $checkStmt = $db->prepare($checkDuplicateQuery);
    $checkStmt->bindParam(1, $shopName, SQLITE3_TEXT);
    $result = $checkStmt->execute();
    $rowCount = $result->fetchArray(SQLITE3_NUM);
    $rowCount = $rowCount[0];

    if ($rowCount == 0) {
        echo "<a href='../../index.php' class='btn btn-small btn-primary'>&lt;&lt; BACK</a>";
        exit;
    }

    $fetchQuery = "SELECT * FROM Buckets WHERE ShopName = ?";
    $fetchStmt = $db->prepare($fetchQuery);
    $fetchStmt->bindParam(1, $shopName, SQLITE3_TEXT);
    $result = $fetchStmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);

    // Assign values to variables
    $shopName = $row['ShopName'];
    $category = $row['Category'];
};

$db->close();
?>

<table>
    <tr>
        <td>Shop Name: </td>
        <td><?php echo $shopName ?></td>
    </tr>
    <tr>
        <td>Category: </td>
        <td><?php echo $category ?></td>
    </tr>
</table>
<br />
<form action="process_delete.php" method="post">
    <input type="hidden" value="<?php echo $shopName ?>" name="shopName" />
    <a href="../../index.php" class="btn btn-small btn-primary">&lt;&lt; BACK</a>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Delete" class="btn btn-danger" name="delete" />
</form>

<br />
<?php
include '../../footer.php';
?>