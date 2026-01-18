<?php 
    include 'db.php'; 
    session_start(); 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
        $fullname = mysqli_real_escape_string($conn ,$_POST['fullname']); 
        $email = mysqli_real_escape_string($conn ,$_POST['email']); 
        $username = mysqli_real_escape_string($conn ,$_POST['username']); 
        $password = mysqli_real_escape_string($conn ,$_POST['password']); 
        $cpass = mysqli_real_escape_string($conn ,$_POST['cpass']); 
        
        //Password Validation 
        
        if ($password != $cpass)
        { 
            $_SESSION['error'] = "Passwords do not match";
            header("Location: registration-form.php");
            exit; 
        } 
        
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT); 

        //Check if username exists

        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");

        mysqli_stmt_bind_param($stmt, "s", $username);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) 
        {
            $_SESSION['error'] = "Username already in use";
            header("Location: registration-form.php");
            exit;
        }

        mysqli_stmt_close($stmt);
        
        //Check if email exists

        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) 
        {
            $_SESSION['error'] = "Email already in use";
            header("Location: registration-form.php");
            exit;
        }

        mysqli_stmt_close($stmt);    
        
        //Inserting to database 
        try
        {
            $stmt = mysqli_prepare($conn,"INSERT INTO users (email, username, passwd, fullname) 
                                                        VALUES (?, ?, ?, ?)");
                    
            mysqli_stmt_bind_param( $stmt, "ssss", $email, $username, $hashed_pass, $fullname );
            
            if (mysqli_stmt_execute($stmt)) 
            { 
                error_log("REGISTRATION_SUCCESS: New user '$username' registered with email '$email'");
                $_SESSION['success'] = "Account created successfully. You may now log in."; 
                header("Location: login-form.php"); 
                exit; 
            } 
            else 
            { 
                $_SESSION['error'] = "Registration failed. Please try again.";
                header("Location: registration-form.php"); 
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