<?php
session_destroy(); // Destroy the session
// destroy the session variables
unset($_SESSION['loggedin']);
unset($_SESSION['role']);
unset($_SESSION['email_err']);
unset($_SESSION['password_err']);
unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['authorization_error']);

header('Location: ../login/index.php'); // Redirect to the login page
exit();
?>