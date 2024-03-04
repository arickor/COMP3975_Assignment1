<?php

// Assuming you have already established a connection to the SQLite database
include 'include_db.php';

// Get the user data from the POST request
$email = $_POST['email'];
$password = $_POST['password'];
$admission = $_POST['admission'];

// Prepare the SQL statement to insert the user data into the User table
$sql = "INSERT INTO User (email, password, admission) VALUES (:email, :password, :admission)";
$stmt = $db->prepare($sql);

// Bind the values to the parameters in the SQL statement
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':admission', $admission);

// Execute the SQL statement
if ($stmt->execute()) {
    // User data inserted successfully
    echo "User data inserted successfully";
} else {
    // Error occurred while inserting user data
    echo "Error occurred while inserting user data";
}

?>
