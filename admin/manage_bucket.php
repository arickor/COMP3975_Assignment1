<?php
require $_SERVER['DOCUMENT_ROOT'] . '/initialize.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: /login/index.php');
    exit();
} elseif ($_SESSION["role"] !== "admin") {
    header("location: /index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buckets</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <?php
        // Assuming you have already connected to the SQLite database

        echo "
        <div class='d-flex justify-content-between mb-3'>
            <button onclick='goToIndex()' class='btn btn-primary'>Go Back</button>
            <a class='btn btn-success' href='/bucket_actions/create/create.php'>Create New</a>
        </div>
        ";

        echo "
        <script>
        function goToIndex() {
          window.location.href = '../index.php';
        }
        </script>
        ";

        // Retrieve the Category and ShopName from the Buckets table
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';


      //delete all elements in UncategorizedShops
        // $db->exec("DELETE FROM UncategorizedShops");

        $resultSet = $db->query("SELECT * FROM UncategorizedShops");

        if ($resultSet->fetchArray()) {
            // Data exists in the UncategorizedShops table, show the table
            echo '<div class="d-inline-block">';
            echo '<h2>Uncategorized Shop Names</h2>';
            echo '<table class="table table-striped">';
            echo '<thead class="thead-dark"><tr><th>Shop Name</th></tr></thead>';

            // Reset resultSet to the beginning
            $resultSet->reset();

            while ($row = $resultSet->fetchArray()) {
                echo '<tr><td>' . $row['ShopName'] . '</td></tr>';
            }

            echo '</table>';
            echo '</div>';
        }

        $query = "SELECT Category, ShopName FROM Buckets";
        $result = $db->query($query);

        // Add a title for the table
        echo "<h2>Buckets</h2>";

        // Create the table
        echo "<table class='table table-striped'>";
        echo "<thead class='thead-dark'><tr><th>Category Name</th><th>Shop Name</th><th>Actions</th></tr></thead>";

        // Loop through the result and populate the table rows
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['Category'] . "</td>";
            echo "<td>" . $row['ShopName'] . "</td>";
            echo "<td>";
            echo "<a class='btn btn-warning' href='/bucket_actions/update/update.php?category=" . urlencode($row['Category']) . "&shopName=" . urlencode($row['ShopName']) . "'>Update</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-danger' href='/bucket_actions/delete/delete.php?category=" . urlencode($row['Category']) . "&shopName=" . urlencode($row['ShopName']) . "'>Delete</a>";
            echo "</td></tr>\n";
        }

        echo "</table>";
        ?>
    </div>
    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
include '../footer.php';
?>

</html>