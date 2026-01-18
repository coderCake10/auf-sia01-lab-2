<?php
    include 'db.php';

    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        //Retrieve user record

        try
        {
        $stmt = mysqli_prepare($conn, "SELECT id, passwd, email, fullname FROM users WHERE username = ?");

        mysqli_stmt_bind_param($stmt, "s", $username);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) //If it isn't 0, that means the user was found
        {
            //Username exists, store password associated with username
            mysqli_stmt_bind_result($stmt, $id, $hashed_pass, $email, $fullname);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed_pass))
            {
                //Login success

                session_regenerate_id(true);

                //Set session variables

                $_SESSION['is_logged_in'] = true;
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['login_time'] = date('Y-m-d H:i:s');

                error_log("LOGIN_SUCCESS: User '$username' successfully logged in.");
                $_SESSION['success'] = "Login successful";
                header("Location: welcome.php");
                exit;
            }
            else
            {
                //Display error message for incorrect username or password
                error_log("LOGIN_FAILED: Incorrect password attempt for username '$username'.");
                $_SESSION['error'] = "Incorrect username or password. Please try again.";
                header("Location: login-form.php");
                exit;
            }
        }
        else
        {
            //Display error message for user not found
            error_log("LOGIN_FAILED: Attempted login for non-existent user '$username'.");
            $_SESSION['error'] = "Incorrect username or password. Please try again.";
            header("Location: login-form.php");
            exit;
        }
        }
        catch (mysqli_sql_exception $e)
        {
            error_log("DATABASE ERROR: " . $e->getMessage());

            $_SESSION['error'] = "Error occured. Please try again later.";
            header("Location: login-form.php");
            exit;
        }
    }
?>