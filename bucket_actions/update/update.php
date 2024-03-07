<?php
require '../../initialize.php';

// Include your database connection file and your Bucket class
require_once("../../buckets/buckets.php");

// Get the id from the GET parameters
$shopName = isset($_GET['shopName']) ? urldecode($_GET['shopName']) : null;

include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

// Prepare an SQL statement
$stmt = $db->prepare("SELECT * FROM Buckets WHERE shopName = ?");
$stmt->bindValue(1, $shopName);

// Execute the SQL statement and fetch the result
$result = $stmt->execute();
$bucket = $result->fetchArray(SQLITE3_ASSOC);

// Check if a bucket was found
if ($bucket === false) {
    // No bucket was found, return an empty array
    $bucket = array();
}

// Close the database connection
$db->close();

// Extract the bucket details
$categoryValue = $bucket['Category'];
$shopNameValue = $bucket['ShopName'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Bucket</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="text-center">Update Bucket</h1>
                <form action="process_update.php" method="post">
                    <input type="hidden" id="shopName" name="shopName" value="<?php echo $shopNameValue; ?>">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category" class="form-control" value="<?php echo $categoryValue; ?>">
                    </div>
                    <div class="form-group">
                        <label for="shopNameDisplay">Shop Name</label>
                        <input type="text" id="shopNameDisplay" class="form-control" value="<?php echo $shopNameValue; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <a href="/admin/manage_bucket.php" class="btn btn-small btn-primary">&lt;&lt; Back</a>
                        <button type="submit" name="update" class="btn btn-warning float-right">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<?php
include '../../footer.php';
?>
</html>