<?php
require '../initialize.php';

require_once("../transaction/transaction.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file is selected
    if (isset($_FILES["csvFile"]) && $_FILES["csvFile"]["error"] == UPLOAD_ERR_OK) {
        // Get the file details
        $fileTmpPath = $_FILES["csvFile"]["tmp_name"];
        $fileName = $_FILES["csvFile"]["name"];
        $fileSize = $_FILES["csvFile"]["size"];
        $fileType = $_FILES["csvFile"]["type"];

        // Check if the file is a CSV file
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExtension == "csv") {
            // Specify the destination folder
            $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/data/';

            // Generate a unique file name
            $newFileName = $fileName;

            // Move the uploaded file to the destination folder
            $destPath = $uploadFolder . $newFileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                echo '<div class="alert alert-success">File uploaded successfully.</div>';

                // Open the CSV file
                if (($handle = fopen($destPath, "r")) !== false) {
                    // Read each line of the CSV file
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        // Get the transaction details from the CSV file
                        $date = $data[0];
                        $shopName = $data[1];
                        $moneySpent = $data[2];
                        $moneyDeposited = $data[3];

                        // Check if both MoneySpent and MoneyDeposited are empty
                        if ($moneySpent == 0 && $moneyDeposited == 0) {
                            // Skip this row and continue with the next one
                            continue;
                        }

                        // Calculate the new bank balance
                        $bankBalance = Transaction::getLatestBankBalance();
                        if (!empty($moneySpent)) {
                            $bankBalance -= $moneySpent;
                        }
                        if (!empty($moneyDeposited)) {
                            $bankBalance += $moneyDeposited;
                        }

                        // Insert the transaction into the Transaction table
                        Transaction::addTransaction($date, $shopName, $moneySpent, $moneyDeposited, $bankBalance);
                    }

                    // Close the CSV file
                    fclose($handle);
                }

                // Rename the file to add ".imported" to the end of the filename
                $importedFilePath = $destPath . ".imported";
                if (rename($destPath, $importedFilePath)) {
                    echo '<div class="alert alert-success">File renamed to ' . basename($importedFilePath) . '.</div>';
                } else {
                    echo '<div class="alert alert-danger">Failed to rename file.</div>';
                }
                echo '<div class="alert alert-success">File uploaded and transactions imported successfully.</div>';
            } else {
                echo '<div class="alert alert-danger">Failed to upload file.</div>';
            }
        } else {
            echo '<div class="alert alert-warning">Only CSV files are allowed.</div>';
        }
    } else {
        echo '<div class="alert alert-info">No file selected.</div>';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload CSV File</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Upload CSV File</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="csvFile">Select file</label>
                        <input type="file" class="form-control-file" name="csvFile" id="csvFile" accept=".csv">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <!-- Add a back button -->
                    <a href="/index.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
<?php
include '../footer.php';
?>
</html>
