<?php

// Check if the user is logged in, if not then redirect to login page
if ($_SESSION["loggedin"] !== true) {
    header("location: /login/index.php");
    exit;
}

class Buckets
{
    public static function showBucketsTable()
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $resultSet = $db->query('SELECT * FROM Buckets');

        echo "<div class='container mt-5'>";
        echo "<p><a class='btn btn-success mb-3' href='/actions/create/create.php'>Create New</a></p>";
        echo "<table class='table table-striped table-bordered table-hover'>\n";
        echo "<thead class='thead-dark'>";
        echo "<tr><th scope='col'>Category</th>
        <th scope='col'>ShopName</th>
        <th scope='col'>Actions</th>
        </tr>\n";
        echo "</thead><tbody>";

        while ($row = $resultSet->fetchArray()) {
            echo "<tr><td>{$row['Category']}</td>";
            echo "<td>{$row['ShopName']}</td>";
            echo "<td>";
            echo "<a class='btn btn-warning' href='/actions/update/update.php?category=" . urlencode($row['Category']) . "&shopName=" . urlencode($row['ShopName']) . "'>Update</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-danger' href='/actions/delete/delete.php?category=" . urlencode($row['Category']) . "&shopName=" . urlencode($row['ShopName']) . "'>Delete</a>";
            echo "</td></tr>\n";
        }
        echo "</tbody></table>\n";
        echo "</div>";

        $db->close();
    }

    public static function addBucket($category, $shopName)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $stmt = $db->prepare("INSERT INTO Buckets (Category, ShopName) VALUES (?, ?)");

        $stmt->bindValue(1, $category);
        $stmt->bindValue(2, $shopName);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        $db->close();
    }

    public static function getBucket($shopName)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $stmt = $db->prepare("SELECT * FROM Buckets WHERE ShopName = ?");

        $stmt->bindValue(1, $shopName);

        $result = $stmt->execute();
        $bucket = $result->fetchArray(SQLITE3_ASSOC);

        if ($bucket === false) {
            $bucket = array();
        }

        $db->close();

        return $bucket;
    }

    public static function updateBucket($category, $shopName)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $stmt = $db->prepare("UPDATE Buckets SET Category = ? WHERE ShopName = ?");

        $stmt->bindValue(1, $category);
        $stmt->bindValue(2, $shopName);

        if ($stmt->execute() === false) {
            return array('error' => 'Failed to update bucket');
        }

        $db->close();

        return array();
    }

    public static function deleteBucket($shopName)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

        $stmt = $db->prepare("DELETE FROM Buckets WHERE ShopName = ?");

        $stmt->bindValue(1, $shopName);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }

        $db->close();

        return ['success' => true];
    }
}
