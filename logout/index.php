<?php
session_destroy(); // Destroy the session
header('Location: ../login/index.php'); // Redirect to the login page
exit();
?>