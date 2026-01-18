<?php
    session_start();

    $_SESSION['success'] = "User logged out successfully";

    session_unset();
    session_destroy();

    session_start();
    
    $_SESSION['success'] = "User logged out successfully";
    header("Location: login-form.php");
    exit;
?>