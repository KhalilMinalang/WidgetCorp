<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php include("../includes/layouts/header.php"); ?>

<?php
    if(isset($_GET["subject"])) {
        $selected_subject_id = $_GET["subject"];
        $selected_page_id = null;
    } elseif (isset($_GET["page"])) {
        $selected_page_id = $_GET["page"];
        $selected_subject_id = null;
    } else {
        $selected_page_id = null;
        $selected_subject_id = null;
    }
?>

        <div id="main">
            <div id="navigation">
                <ul class="subjects">
                    <?php $subject_set = find_all_subjects(); ?>
                    <?php
                    while ($subject = mysqli_fetch_assoc($subject_set)) {
                    ?>
                    <?php
                        // highlights the currently "selected" SUBJECT
                        echo "<li";
                        if ($subject["id"] == $selected_subject_id) {
                            echo " class=\"selected\"";
                        }
                        echo ">";
                    ?> 
                        <!-- wrapping in <a> -->
                        <a href="manage_content.php?subject=<?php echo urlencode($subject["id"]); ?>"><?php echo $subject["menu_name"]; ?></a>
                        
                        <?php $page_set = find_pages_for_subject($subject["id"]); ?>
                        <ul class="pages">
                            <?php
                                while ($page = mysqli_fetch_assoc($page_set)) {
                            ?>
                            
                            <?php
                                    // highlights the currently "selected" PAGE
                                    echo "<li";
                                    if ($page["id"] == $selected_page_id) {
                                        echo " class=\"selected\"";
                                    }
                                    echo ">";
                            ?>
                                <a href="manage_content.php?page=<?php echo urlencode($page["id"]); ?>"><?php echo $page["menu_name"]; ?></a>
                            </li>
                             <?php
                                }
                             ?>
                            <?php mysqli_free_result($page_set); ?>
                        </ul>
                    </li>
                    <?php
                    }
                    ?>
                    <?php mysqli_free_result($subject_set); ?>
                </ul>
            </div>
            <div id="page">
                <h2>Manage Content</h2>
                <?php echo $selected_subject_id; ?><br />
                <?php echo $selected_page_id; ?><br />
            </div>
        </div>
        

<?php include("../includes/layouts/footer.php"); ?>
