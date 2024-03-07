<?php
require '../../initialize.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Bucket</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Create New Bucket</h1>

        <div class="row">
            <div class="col-md-4">
                <?php if (!empty($error_message)) : ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>
                <form action="process_create.php" method="post">
                    <div class="form-group">
                        <label for="Category" class="control-label">Category</label>
                        <input type="text" class="form-control" name="category" id="Category" required />
                    </div>

                    <div class="form-group">
                        <label for="ShopName" class="control-label">Shop Name</label>
                        <input type="text" class="form-control" name="shopName" id="ShopName" required />
                    </div>

                    <div class="form-group">
                        <a href="/admin/manage_bucket.php" class="btn btn-small btn-primary">&lt;&lt; Back</a>
                        &nbsp;&nbsp;&nbsp;
                        <input type="submit" value="Create" name="create" class="btn btn-success" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<?php
include '../../footer.php';
?>
</html>