           
<?php

    require_once('page-titles.php');
    $page_title = MR_USER_PAGE;

    require_once('headings.php');
    $heading = MR_USER_HEADING;

    require_once('head.php');

    require_once('heading.php');
    
        //This function's purpose is to display the user information
        function displayUserInfo($user) {
            
            echo "<div class='d-flex flex-column'>";

            if (!isset($_POST['password-to-change'])) {

                require_once('user-info.php');

                require_once('user-account-buttons.php');

            } else {

                require_once('user-password-form.php');
                
            }
                
        }
                
?>
        