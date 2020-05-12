<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php 
	$username = "";

	if (isset($_POST['submit'])) {
		// Process the form

		// validations
		$required_fields = array("username", "password");
		validate_presences($required_fields);

		//$fields_width_max_lengths = array("username" => 30);
		//validate_max_lengths($fields_width_max_lengths);

		if (empty($errors)) {
			// Attempt Login

			$username = $_POST["username"];
			$password = $_POST["password"];

			$found_admin = attempt_login($username, $password);

			if ($found_admin) {
				// Success
				// Mark user a logged in
				//$_COOKIE["admin_id"] = $found_admin["id"];
				$_SESSION["admin_id"] = $found_admin["id"];
				$_SESSION["username"] = $found_admin["username"];
				redirect_to("admin.php");
			} else {
				// Failure
				$_SESSION["message"] = "Username/password not found.";
			}
		}
	} else {
		// This is probably a GET request
	} // end: if (isset($_POST['submit']))
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">
		&nbsp;
	</div>
	<div id="page">
		<?php echo message(); ?>
		<?php echo form_errors($errors); ?>

		<h2>Login</h2>
		<form action="login.php" method="post">
			<p>Username:
				<!-- using "username" in the form as a value, if they've submitted the form previously, then we wanna echo back them their username -->
				<input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
			</p>
			<p>Password:
				<input type="password" name="password" value="" />
			</p>
			<input type="submit" name="submit" value="Submit" />
		</form>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>