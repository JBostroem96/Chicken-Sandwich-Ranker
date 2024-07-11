<?php

    require_once('authorizeaccess.php');
    require_once('pagetitles.php');
    $page_title = MR_SUBMIT_PAGE;

    require_once('headings.php');
    $heading = MR_SUBMIT_HEADING;

?>

<!DOCTYPE html>
<html>
    <?php require_once('head.php'); ?>
    
        <main class='mt-4'>
            <?php require_once('heading.php'); ?>
                
                
                <main class="mt-2">
                    <?php require_once("form.php"); ?>
                </main>
                
            </div>
        </main>
    </body>
    <?php require_once("footer.php"); ?>
</html>