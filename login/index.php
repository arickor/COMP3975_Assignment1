<?php
// Start the session
session_start();

// Get data from session variables
// $email = isset($_SESSION["email"]) ? $_SESSION["email"] : '';
// $password = isset($_SESSION["password"]) ? $_SESSION["password"] : '';
$password_err = isset($_SESSION["password_err"]) ? $_SESSION["password_err"] : '';
$email_err = isset($_SESSION["email_err"]) ? $_SESSION["email_err"] : '';

// check is loggedin session, and then show error message

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
            margin: 0;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php
        if (isset($_SESSION['authorization_error'])) {
            echo '<div id="error-message" class="alert alert-danger" role="alert">' . $_SESSION['authorization_error'] . '</div>';
            unset($_SESSION['authorization_error']);
        }
        ?>
        <div class="toast">
            <div class="toast-body">
            </div>
        </div>
        <h2>Login</h2>
        <form action="../login/process_login.php" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">

            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <div>
                <p>Don't have an account? <a href="../signup/index.php">Sign up now</a>.</p>
            </div>
        </form>
    </div>
</body>

</html>
<!-- <?php
        // Unset the session variables
        unset($_SESSION["email_err"]);
        unset($_SESSION["password_err"]);
        unset($_SESSION["email"]);
        unset($_SESSION["password"]);
        ?> -->

<script>
    window.onload = function() {
        // After 5 seconds, remove the error message
        setTimeout(function() {
            var element = document.getElementById('error-message');
            if (element) {
                element.style.display = 'none';
            }
        }, 3000);
    };
    $(document).ready(function() {
        <?php if (strlen($email_err) > 0) { ?>
            $('.toast').toast({
                delay: 5000
            });
            $('.toast-body').text('<?php echo $email_err; ?>');
            $('.toast').toast('show');
        <?php } ?>
        <?php if (strlen($password_err) > 0) { ?>
            $('.toast').toast({
                delay: 5000
            });
            $('.toast-body').text('<?php echo $password_err; ?>');
            $('.toast').toast('show');
        <?php } ?>
    });
</script>