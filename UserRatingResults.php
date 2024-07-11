<?php

    require_once('pagetitles.php');
    $page_title = MR_USERRATINGS_PAGE;

    require_once('headings.php');
    $heading = MR_USERRATINGS_HEADING;

    require_once('head.php'); ?>

    <main class='mt-2'>

        <?php require_once('heading.php');               
            
            //This class' purpose is to display the user rating results
            class UserRatingResults {

                //This function's purpose is to display the user ratings
                public function display($rating) {
                                                
                    echo "<div class='rating'>" 
                        . "<form action='user_chicken_sandwich_service.php' method='POST'>
                        <h2 class='fw-bold'>Your rating for {$rating->getName()}: {$rating->getScore()}<br>"; 
                                        
                        if (isset($_POST['edit_entry'])) {
                                                
                            if ($_POST['chicken_id'] == $rating->getChicken_id()) {
                                                    
                                echo "<input type='numeric' name='score' pattern='[1-9]|10'>";
                                echo "<button class='button' type='submit' id='edit_score'
                                    name='edit_score' value='{$_POST['chicken_id']}'>RATE ME!</button><p>Only 1-10 is allowed, one rating per account</p>";
                                            
                            } 
                                                
                        } 

                    echo "<input type='hidden' name='chicken_id' value='{$rating->getChicken_id()}'>
                        <button class='button' type='submit' id='delete_entry'
                        name='delete_entry' value='{$rating->getScore()}'>DELETE</button>"
                        . "<button class='button' type='submit' id='edit_entry'
                        name='edit_entry'>EDIT</button></form></div></div>";
                }           
                                
            }
        
        ?> 

    </main>

    <?php require_once("footer.php"); ?>

</body>  

</html>

    
