<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100" style="background-color: #fff3c2;">

    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Login</h3>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success text-center" role="alert">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
            <?php
                unset($_SESSION['success']);
            endif;
            ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
            <?php
                unset($_SESSION['error']);
            endif;
            ?>

            <form action="login.php" method="post">
                
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>

                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>

            </form>
            
            <div class="mt-3 text-center">
                <small>Don't have an account? <a href="registration-form.php">Register here</a></small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>