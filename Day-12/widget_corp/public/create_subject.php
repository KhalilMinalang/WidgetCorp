<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php 
	if (isset($_POST['submit'])) {
		// Process the form

		// Often these are form values in $_POST
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"]; // makes sure that it's "type cast" as an integer
		$visible = (int) $_POST["visible"]; // we could cast this as (int) || (bool) 
		
		// Perform database query
		$query = "INSERT INTO subjects (";
		$query .= " menu_name, position, visible";
		$query .= ") VALUES (";
		$query .= " '{$menu_name}', {$position}, {$visible}"; // should not be surrounding int variables with single or double quotes.
		$query .= ")";
		$result = mysqli_query($connection, $query);

		// Test if there was a query error
		if ($result) {
		    // Success
		    $message = "Subject created.";
		    redirect_to("manage_content.php");
		} else {
		    // Failure
		    $message = "Subject creation failed";
		    redirect_to("new_subject.php");
		}
	} else {
		// This is probably a GET request
		redirect_to("new_subject.php");
	}

?>

<?php
	// Close database connection
    if (isset($connection)) { mysqli_close($connection); }
?>