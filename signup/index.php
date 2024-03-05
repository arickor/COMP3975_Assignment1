<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    .mt-custom {
        margin-top: 15vh;
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center mt-custom">
            <div class="col-lg-4">
                <h1>Sign Up</h1>
                <form action="/signup/process_signup.php" method="POST" id="signupForm">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                        <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="admission" name="admission">
                        <label class="form-check-label" for="admission">Are you an administrator?</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var form = document.getElementById('signupForm');
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            }, false);
        })();
    </script>
</body>

</html>