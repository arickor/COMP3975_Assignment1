<?php
include '../include_db.php';

$email = $_POST['email'];
$password = $_POST['password'];
$isAdmin = isset($_POST['admission']) ? 1 : 0;
$isApproved = $isAdmin ? 1 : 0;
// Prepare the SQL statement to insert the user data into the User table$sql = "INSERT INTO Users (Email, Password, IsAdmin, IsApproved) VALUES (:email, :password, :isAdmin, :isApproved)";
$sql = "INSERT INTO Users (Email, Password, IsApproved, IsAdmin) VALUES (:email, :password, :isApproved, :isAdmin)";
$stmt = $db->prepare($sql);


$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':isAdmin', $isAdmin, SQLITE3_INTEGER);
$stmt->bindParam(':isApproved', $isApproved, SQLITE3_INTEGER);


if ($stmt->execute()) {
    header('Location: /login');
} else {
    echo "Error occurred while inserting user data";
}
