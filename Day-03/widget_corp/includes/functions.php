<?php
    // Test if there was a query error
    function confirm_query($result_set) {
        if (!$result_set) {
            die("Database query failed.");
        }
    }
?>