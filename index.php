<?php
require $_SERVER['DOCUMENT_ROOT'] . '/initialize.php';
?>

<!-- <h1>it works</h1> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/create_table/index.php';

    // include $_SERVER['DOCUMENT_ROOT'] . '/import/import.php';
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <?php if ($_SESSION['role'] === 'admin') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/manage_users.php">Manage users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/manage_bucket.php">Manage buckets</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/logout/index.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/transaction/transaction.php';
    Transaction::showTransactionTable();
    ?>

</body>
<?php
include 'footer.php';
?>

</html>