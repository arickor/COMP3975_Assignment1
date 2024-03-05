<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/transaction/transaction.php';



// Get the year input from the user
if (isset($_POST['year'])) {
    $year = $_POST['year'];
    Transaction::showYearlyReport($year);
}
?>

<!-- Your HTML form to get the year input from the user -->
<form method="POST">
    <label for="year">Enter the year:</label>
    <input type="text" name="year" id="year">
    <button type="submit">Generate Report</button>
</form>
