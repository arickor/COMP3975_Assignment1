<?php
require '../initialize.php';

// Connect to the SQLite database
include '../include_db.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: /login/index.php');
    exit();
} elseif ($_SESSION["role"] !== "admin") {
    header("location: /index.php");
    exit();
}


// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['users'])) {
    // Update the IsApproved field for each submitted email
    foreach ($_POST['users'] as $email => $isApproved) {
        $isApproved = $isApproved === 'on' ? 1 : 0;
        $query = "UPDATE Users SET IsApproved = $isApproved WHERE Email = '$email'";
        $db->exec($query);
    }

    // alert message if the update was successful
    echo "<script>alert('User data updated successfully');</script>";
}

// Retrieve user data from the Users table
$query = "SELECT Email, IsApproved FROM Users WHERE IsAdmin = 0";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Table</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Email</th>
                                <th>Is Approved</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) : ?>
                                <tr>
                                    <td><?php echo $row['Email']; ?></td>
                                    <td>
                                        <input type="hidden" name="users[<?php echo $row['Email']; ?>]" value="off">
                                        <input type="checkbox" name="users[<?php echo $row['Email']; ?>]" <?php echo $row['IsApproved'] ? 'checked' : ''; ?>>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-light">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='../index.php'">Back</button>

                </form>
            </div>
        </div>
    </div>
    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
include '../footer.php';
?>
</html>

<?php
// Close the database connection
$db->close();
?>