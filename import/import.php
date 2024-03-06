<?php
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
        echo $fileExtension;
        if ($fileExtension == "csv") {
            // Specify the destination folder
            $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/data/';
            
            // Generate a unique file name
            $newFileName = $fileName;
            
            // Move the uploaded file to the destination folder
            $destPath = $uploadFolder . $newFileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                echo "File uploaded successfully.";
            } else {
                echo "Failed to upload file.";
            }
        } else {
            echo "Only CSV files are allowed.";
        }
    } else {
        echo "No file selected.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV File</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="csvFile" accept=".csv">
        <input type="submit" value="Upload">
    </form>
<br>
    <a href="/index.php">Back</a>
</body>
<?php
include '../footer.php';
?>
</html>
