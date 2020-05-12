<div id="footer">Copyright 20xx, Widget Corp</div>
        
	</body>
</html>
<?php
    // 5. Close database connection
    // it's a good practice to check and see whether a connection to the database has been set before we start trying to close it.

    if (isset($connection)) {
        mysqli_close($connection);
    }
?>
