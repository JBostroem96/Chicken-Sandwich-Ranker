<?php

    session_start();
    require_once('pagetitles.php');
    $page_title = MR_HOME_PAGE;

    require_once('headings.php');
    $heading = MR_HOME_HEADING;

    require_once('UserManager.php');
?>

<!DOCTYPE html>
<html>
    <?php require_once('head.php'); ?>

        <main class='mt-4'>
            
            <?php require_once('heading.php'); ?>
            <p class="text-center mt-5">This is a Web Application that ranks submitted chicken sandwiches by their score. It has CRUD, and authentication and authorization.
                The submissions are done by the admin, then users can score them.
            </p>

        </main>
        
    <?php require_once("footer.php"); ?>
        
    </body>  
</html>






