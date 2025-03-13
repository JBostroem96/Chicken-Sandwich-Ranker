<?php

    session_start();
    require_once('pagetitles.php');
    $page_title = MR_HOME_PAGE;

    

    require_once('UserManager.php');
?>

<!DOCTYPE html>
<html>
    <?php require_once('head.php'); ?>


        <main class='mt-4'>
            
            <h1 class="appearOnScroll">Hello</h1>

        </main>
        
        <?php require_once("footer.php"); ?>
        
    </body>  
</html>






