<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include_db.php';

ob_start(); // Start output buffering at the beginning of your script
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
        // include_once '../include_db.php';
        $sql = 'SELECT * FROM Users WHERE Email = :email';
        $stmt = $db->prepare($sql);

        if ($stmt) {
            $stmt->bindParam(':email', $email, SQLITE3_TEXT);
            $result = $stmt->execute();

            if ($result) {
                $row = $result->fetchArray(SQLITE3_ASSOC);
                if ($row) {
                    if ($password === $row['Password']) { // Compare the passwords
                        if ($row['IsApproved'] == 1) {
                            // header('Location: ../index.php');
                            if ($row['IsAdmin'] == 1) {
                                $_SESSION['role'] = "admin";
                            } else {
                                $_SESSION['role'] = "user";
                            }
                            $_SESSION['loggedin'] = true;
                            header('Location: ../index.php');
                            exit();
                        } else {
                            $email_err = 'Your account has not been approved yet.';
                            header('Location: index.php');
                        }
                    } else {
                        $password_err = 'Incorrect password.';
                        header('Location: index.php');
                    }
                } else {
                    $email_err = 'Email does not exist.';
                    header('Location: index.php');
                }
                $_SESSION['email_err'] = $email_err;
                $_SESSION['password_err'] = $password_err;
                header('Location: index.php');
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }

            unset($stmt);
        }
    }
    }
    // Close the database connection
    $db->close();

