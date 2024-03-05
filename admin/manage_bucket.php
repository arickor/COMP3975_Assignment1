<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /login/index.php");
    $_SESSION['authorization_error'] = 'Please login to view the page';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <?php
        // Assuming you have already connected to the SQLite database

        // Retrieve the Category and ShopName from the Buckets table
        include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';
        $query = "SELECT Category, ShopName FROM Buckets";
        $result = $db->query($query);

        // Create the table
        echo "<table class='table table-striped'>";
        echo "<thead class='thead-dark'><tr><th>Category</th><th>ShopName</th></tr></thead>";

        // Loop through the result and populate the table rows
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['Category'] . "</td>";
            echo "<td>" . $row['ShopName'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        ?>
    </div>
    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>