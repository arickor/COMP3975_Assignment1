<?php
session_start();
// Check if the user is logged in, if not then redirect to login page
if ($_SESSION["loggedin"] !== true) {
    header("location: /login/index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="d-flex justify-content-center mt-5">
        <a href="/index.php" class="btn btn-primary">Back</a>
    </div>
    <!-- Your HTML form to get the year input from the user -->
    <div class="d-flex justify-content-center mt-5">
        <form method="POST">
            <label for="year">Enter the year:</label>
            <input type="text" name="year" id="year">
            <button type="submit" class="btn btn-success">Enter</button>
        </form>
    </div>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/transaction/transaction.php';
    global $year;
    // Get the year input from the user
    if (isset($_POST['year'])) {
        $year = $_POST['year'];
        Transaction::showYearlyReport($year);
        echo '<div class="d-flex justify-content-center">
        <form method="POST">
            <input type="hidden" name="year" value="' . $year . '">
            <input type="hidden" name="showChart" value="1">
            <button type="submit" class="btn btn-success">Show the pie chart</button>
        </form>
    </div>';
    }

    // Show the pie chart
    if (isset($_POST['showChart'])) {
        $year = $_POST['year'];
        Transaction::showYearlyChart($year);
    }

    ?>




</body>

<?php
include '../footer.php';
?>

</html>