<?php
    include 'db.php';

    session_start();

    if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
        $_SESSION['error'] = "User must be logged in";
        header("Location: login-form.php");
        exit;
    }

    $stmt = mysqli_prepare($conn, "SELECT username, email, fullname FROM users");

    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $username, $email, $fullname);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #fff3c2">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Dashboard</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    Welcome, <?php echo $_SESSION['username']; ?>!
                </span>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">My Profile</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title text-primary"><?php echo $_SESSION['fullname']; ?></h3>
                        <p class="text-muted mb-1"><?php echo $_SESSION['email']; ?></p>
                        <hr>
                        <small class="text-secondary">
                            <strong>Login Time:</strong> <br> 
                            <?php echo $_SESSION['login_time']; ?>
                        </small>
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success text-center" role="alert">
                                <?= htmlspecialchars($_SESSION['success']) ?>
                            </div>
                        <?php
                            unset($_SESSION['success']);
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Registered Users</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Full Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while (mysqli_stmt_fetch($stmt)): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($username) ?></td>
                                            <td><?= htmlspecialchars($email) ?></td>
                                            <td><?= htmlspecialchars($fullname) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php mysqli_stmt_close($stmt); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>