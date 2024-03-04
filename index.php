<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>

    <?php
    require_once('transaction/transaction.php');
    include 'create_table/index.php';
    include 'import/index.php';

    Transaction::showTransactionTable();

    ?>

</body>

</html>