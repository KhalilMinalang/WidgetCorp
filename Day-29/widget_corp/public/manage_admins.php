<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
	$admin_set = find_all_admins();
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

        <div id="main">
            <div id="navigation">
            	<br>
                  <a href="admin.php">&laquo; Main menu</a><br />
            </div>
            <div id="page">
            	<?php echo message(); ?>
            	<h2>Manage Admins</h2>
            	<table>
            		<tr>
            			<th style="text-align: left; width: 200px;">Username</th>
            			<th colspan="2" style="text-align: left;">Actions</th>
            		</tr>
            		<?php while ($admin = mysqli_fetch_assoc($admin_set)) { ?> <!-- while we're able to find an admin in the admin set -->
            		<tr>
            			<td><?php echo htmlentities($admin["username"]); ?>
                                    <br />
                                    <?php echo htmlentities($admin["hashed_password"]); ?>
                              </td>
            			<td><a href="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>">Edit</a></td>
            			<td><a href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
            		</tr>
            		<?php } ?>
            	</table>
            	<br />
            	<a href="new_admin.php">Add new admin</a>
                  <!-- <hr /> -->
                  <?php 

                  /*$password = "secret";
                  //$hash_format = "$2y$10$";
                  $hash_format = "$2y$11$";
                  //$salt = "Salt22CharactersOrMoreOrMoreOrMore";
                  //$salt = "Salt22Characters";
                  $salt = "Salt22CharactersOrMore";
                  echo "Length: " . strlen($salt);
                  $format_and_salt = $hash_format . $salt;

                  $hash = crypt($password, $format_and_salt);
                  echo "<br />";
                  echo $hash;

                  $hash2 = crypt("secret", $hash);
                  echo "<br />";
                  echo $hash2;*/

                  ?>
            </div>
        </div>

<?php include("../includes/layouts/footer.php"); ?>