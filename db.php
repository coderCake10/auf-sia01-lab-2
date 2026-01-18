<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //ERROR HANDLING

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "sia_lab_act";

    try //ERROR HANDLING
    {
        $conn = new mysqli($server, $username, $password, $database);

    } catch (mysqli_sql_exception $e) {
        error_log("Database connection failed: " . $e->getMessage());
        echo "<p>Connection error occured. Please try again later.</p>";
        exit;
    }
?>