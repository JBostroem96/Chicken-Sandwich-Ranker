<?php

    require_once('authorize-access.php');
    require_once('page-titles.php');
    $page_title = MR_SUBMIT_PAGE;

    require_once('headings.php');
    $heading = MR_SUBMIT_HEADING;

?>

<!DOCTYPE html>
<html>
    <?php require_once('head.php'); ?>
    
    <body>
        <main class='mt-4'>

            <?php require_once('heading.php'); ?>
                
            <?php require_once("enter-chicken-sandwich-form.php"); ?>
                
        </main>
    </body>

    <?php require_once("footer.php"); ?>
    
</html>