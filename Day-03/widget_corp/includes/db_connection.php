<?php
    define("DB_SERVER", "localhost"); // best practice is to define db vars as "CONSTANTS"
    define("DB_USER", "widget_cms");
    define("DB_PASS", "secretpassword");
    define("DB_NAME", "widget_corp");

    // 1. Create a dabase connection
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    // Test if connection occurred.
    if(mysqli_connect_errno()) {
        die("Database connection failed: " .
            mysqli_connect_error() .
            " (" . mysqli_connect_errno() . ")"
        );
    }
?>