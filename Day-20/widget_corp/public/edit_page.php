<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_page(); ?>

<?php
    // Unlike new_page.php, we don't need a subject_id to be sent
    // We already have it stored in pages.subject_id.
    if (!$current_page) {
        // page ID was missing or invalid or
        // page couldn't be found in database
        redirect_to("manage_content.php");
    }
?>

<!-- form processing -->
<?php 
    if (isset($_POST['submit'])) {
        // Process the form

        $id = $current_page["id"];
        // Often these are form values in $_POST
        $menu_name = mysql_prep($_POST["menu_name"]);
        $position = (int) $_POST["position"]; // makes sure that it's "type cast" as an integer
        $visible = (int) $_POST["visible"]; // we could cast this as (int) || (bool) 
        $content = mysql_prep($_POST["content"]);

        // validations
        $required_fields = array("menu_name", "position", "visible", "content");
        validate_presences($required_fields);

        $fields_with_max_lengths = array("menu_name" => 30);
        validate_max_lengths($fields_with_max_lengths);

        if (empty($errors)) {

            // Perform Update

            // Perform database query
            $query = "UPDATE pages SET ";
            $query .= "menu_name = '{$menu_name}', "; // should not be surrounding int variables with single or double quotes.
            $query .= "position = {$position}, ";
            $query .= "visible = {$visible}, "; // A BUG ENCOUNTERED because we missed a comma
            $query .= "content = '{$content}' ";
            $query .= "WHERE id = {$id} ";
            $query .= "LIMIT 1";
            $result = mysqli_query($connection, $query);

            // Test if there was a query error
            if ($result && mysqli_affected_rows($connection) == 1)/* before update */
            /*if ($result && mysqli_affected_rows($connection) >= 0)*/ { // this is the better way to do it because it allows us to account for the fact that the data might be exactly the same
                // Success
                $_SESSION["message"] = "Page updated.";
                redirect_to("manage_content.php?page={$id}");
            } else {
                // Failure
                $_SESSION["message"] = "Page update failed.";
            }
        }

    } else {
        // This is probably a GET request

    } // end: if (isset($_POST['submit']))

?>

<!-- form -->
<?php include("../includes/layouts/header.php"); ?>

        <div id="main">
            <div id="navigation">
                <?php echo navigation($current_subject, $current_page); ?>
            </div>
            <div id="page">
                <?php echo message(); ?>
                <?php echo form_errors($errors); ?>
                
                <h2>Edit Page: <?php echo htmlentities($current_page['menu_name']); ?></h2>
                <!-- it should submit to its' self -->
                <form action="edit_page.php?page=<?php echo urlencode($current_page['id']); ?>" method="post">
                    <p>Menu name:
                        <input type="text" name="menu_name" value="<?php echo htmlentities($current_page['menu_name']); ?>" />
                    </p>
                    <p>Position:
                        <select name="position">
                        <!-- counting positions from db -->
                        <?php
                            //$subject_count = 8;
                            $page_set = find_pages_for_subject($current_page["subject_id"]); // SECRET TECHNIQUE: returns all pages to us
                            $page_count = mysqli_num_rows($page_set); // tells us how many rows we have
                            for($count=1; $count <= $page_count; $count++) {
                                echo "<option value=\"{$count}\"";
                                if ($current_page['position'] == $count) {
                                    echo " selected";
                                }
                                echo ">{$count}</option>";
                            }
                        ?>
                        </select>
                    </p>
                    <p>Visible:
                        <input type="radio" name="visible" value="0" <<?php if($current_page['visible'] == 0) { echo "checked"; } ?> /> No
                        &nbsp;
                        <input type="radio" name="visible" value="1" <?php if($current_page['visible'] == 1) { echo "checked"; } ?>/> Yes
                    </p>
                    <p>Content:<br />
                        <textarea name="content" rows="20" cols="80"><?php echo htmlentities($current_page["content"]); ?></textarea>
                    </p>
                    <!-- SUPER IMPORTANT: name="submit" -->
                    <input type="submit" name="submit" value="Edit Page" />
                </form>
                <br />
                <a href="manage_content.php?page=<?php echo urlencode($current_page["id"]); ?>">Cancel</a>
                &nbsp;
                &nbsp;
                <a href="delete_page.php?page=<?php echo urlencode($current_page['id']); ?>" onclick="return confirm('Are you sure?');">Delete page</a>
            </div> 
        </div>
        
<?php include("../includes/layouts/footer.php"); ?>
