<?php


session_start();

$email_err = $password_err = '';
// $email = $password = '';

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);
    $email = $email;
    $password = $password;

    // Validate email
    if (empty(trim($_POST['email']))) {
        $email_err = 'Please enter your email.';
    } else {
        $email = trim($_POST['email']);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    // Check if there are no errors
    if (empty($email_err) && empty($password_err)) {
        include_once '../include_db.php';
        // Prepare a SELECT statement to check if the user exists in the database
        $sql = 'SELECT * FROM Users WHERE email = :email';
        $stmt = $db->prepare($sql);

        if ($stmt) {
            // Bind parameters
            $stmt->bindParam(':email', $email, SQLITE3_TEXT);
            $result = $stmt->execute();


            // Execute the prepared statement
            if ($result) {
                // Check if the user exists

                    // Fetch the user record
                    $row = $result->fetchArray(SQLITE3_ASSOC);
                    if ($row) {
                        if (password_verify($password, $row['password'])) {
                            // Password is correct, redirect to the home page or perform any other action
                            header('Location: ../index.php');
                            exit();
                        } else {
                            // Password is incorrect
                            $password_err = 'Incorrect password.';
                            header('Location: index.php');
                        }
                    } else {
                        // User does not exist
                        $email_err = 'Email does not exist.';
                        header('Location: index.php');
                        
                    }
                    $_SESSION['email_err'] = $email_err;
                    $_SESSION['password_err'] = $password_err;
                    // $_SESSION['email'] = $email;
                    // $_SESSION['password'] = $password;
                    header('Location: index.php');
                }
                // Verify the password

            } else {
                // Error executing the statement
                echo 'Oops! Something went wrong. Please try again later.';
            }
        

            // Close the statement
            unset($stmt);
        }
    }
    // Close the database connection
    $db->close();

