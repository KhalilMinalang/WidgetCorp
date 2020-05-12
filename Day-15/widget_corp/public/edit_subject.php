<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php find_selected_page(); ?>

<?php // if something went wrong, we weren't able to find the current subject.
    if (!$current_subject) {
        // subject ID was missing or invalid or
        // subject couldn't be found in database
        redirect_to("manage_content.php");
    }
?>

<?php include("../includes/layouts/header.php"); ?>


        <div id="main">
            <div id="navigation">
                <?php echo navigation($current_subject, $current_page); ?>
            </div>
            <div id="page">
                <?php echo message(); ?>
                <?php $errors = errors(); ?>
                <?php echo form_errors($errors); ?>
                
                <h2>Edit Subject: <?php echo $current_subject['menu_name']; ?></h2>
                <form action="create_subject.php" method="post">
                    <p>Menu name:
                        <input type="text" name="menu_name" value="<?php echo $current_subject['menu_name']; ?>" />
                    </p>
                    <p>Position:
                        <select name="position">
                        <!-- counting positions from db -->
                        <?php
                            //$subject_count = 8;
                            $subject_set = find_all_subjects(); // SECRET TECHNIQUE: returns all subjects to us
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
            </div> 
        </div>
        
<?php include("../includes/layouts/footer.php"); ?>
