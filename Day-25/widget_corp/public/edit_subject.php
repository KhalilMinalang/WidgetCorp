<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_page(); ?>

<?php // if something went wrong, we weren't able to find the current subject.
    if (!$current_subject) {
        // subject ID was missing or invalid or
        // subject couldn't be found in database
        redirect_to("manage_content.php");
    }
?>

<!-- form processing -->
<?php 
    if (isset($_POST['submit'])) {
        // Process the form

        // validations
        $required_fields = array("menu_name", "position", "visible");
        validate_presences($required_fields);

        $fields_with_max_lengths = array("menu_name" => 30);
        validate_max_lengths($fields_with_max_lengths);

        if (empty($errors)) {

            // Perform Update

            $id = $current_subject["id"];
            // Often these are form values in $_POST
            $menu_name = mysql_prep($_POST["menu_name"]);
            $position = (int) $_POST["position"]; // makes sure that it's "type cast" as an integer
            $visible = (int) $_POST["visible"]; // we could cast this as (int) || (bool) 

            // Perform database query
            $query = "UPDATE subjects SET ";
            $query .= "menu_name = '{$menu_name}', "; // should not be surrounding int variables with single or double quotes.
            $query .= "position = '{$position}', ";
            $query .= "visible = '{$visible}' "; // A BUG ENCOUNTERED because we missed a comma
            $query .= "WHERE id = {$id} ";
            $query .= "LIMIT 1";
            $result = mysqli_query($connection, $query);

            // Test if there was a query error
            //if ($result && mysqli_affected_rows($connection) == 1) /* before update */
            if ($result && mysqli_affected_rows($connection) >= 0) { // this is the better way to do it because it allows us to account for the fact that the data might be exactly the same
                // Success
                $_SESSION["message"] = "Subject updated.";
                redirect_to("manage_content.php");
            } else {
                // Failure
                $message = "Subject update failed";
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
                <?php echo navigation($current_subject, $current_page); ?>
            </div>
            <div id="page">
                <?php // $message is just a variable, doesn't use the SESSION
                    if (!empty($message)) {
                        echo "<div class=\"message\">" . htmlentities($message) . " </div>";
                    }
                ?>
                <?php echo form_errors($errors); ?>
                
                <h2>Edit Subject: <?php echo htmlentities($current_subject['menu_name']); ?></h2>
                <!-- it should submit to its' self -->
                <form action="edit_subject.php?subject=<?php echo urlencode($current_subject['id']); ?>" method="post">
                    <p>Menu name:
                        <input type="text" name="menu_name" value="<?php echo htmlentities($current_subject['menu_name']); ?>" />
                    </p>
                    <p>Position:
                        <select name="position">
                        <!-- counting positions from db -->
                        <?php
                            //$subject_count = 8;
                            $subject_set = find_all_subjects(false); // SECRET TECHNIQUE: returns all subjects to us
                            $subject_count = mysqli_num_rows($subject_set); // tells us how many rows we have
                            for($count=1; $count <= $subject_count; $count++) {
                                echo "<option value=\"{$count}\"";
                                if ($current_subject['position'] == $count) {
                                    echo " selected";
                                }
                                echo ">{$count}</option>";
                            }
                        ?>
                        </select>
                    </p>
                    <p>Visible:
                        <input type="radio" name="visible" value="0" <<?php if($current_subject['visible'] == 0) { echo "checked"; } ?> /> No
                        &nbsp;
                        <input type="radio" name="visible" value="1" <?php if($current_subject['visible'] == 1) { echo "checked"; } ?>/> Yes
                    </p>
                    <!-- SUPER IMPORTANT: name="submit" -->
                    <input type="submit" name="submit" value="Edit Subject" />
                </form>
                <br />
                <a href="manage_content.php">Cancel</a>
                &nbsp;
                &nbsp;
                <a href="delete_subject.php?subject=<?php echo urlencode($current_subject['id']); ?>" onclick="return confirm('Are you sure?');">Delete subject</a>
            </div> 
        </div>
        
<?php include("../includes/layouts/footer.php"); ?>
