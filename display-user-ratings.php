<?php

    require_once('page-titles.php');
    $page_title = MR_USERRATINGS_PAGE;

    require_once('headings.php');
    $heading = MR_USERRATINGS_HEADING;

    require_once('head.php'); ?>

    <main class='mt-2'>

        <?php require_once('heading.php');               

            //This function's purpose is to display the user ratings
            function displayUserRatings($rating) {
                                                
                    echo "<div class='rating'>" 
                        . "<form action='user-chicken-sandwich-service.php' method='POST'>
                        <h2 class='fw-bold'>Your rating for {$rating->getName()}: {$rating->getScore()}<br>"; 
                                        
                        if (isset($_POST['edit-entry'])) {
                                                
                            if ($_POST['chicken-sandwich-id'] == $rating->getChickenSandwichId()) {
                                                    
                                echo "<input type='numeric' name='score' pattern='[1-9]|10'>";
                                echo "<button class='button' type='submit' id='edit-score'
                                    name='edit-score' value='{$_POST['chicken-sandwich-id']}'>RATE ME!</button><p>Only 1-10 is allowed, one rating per account</p>";
                                            
                            } 
                                                
                        } 

                    echo "<input type='hidden' name='chicken-sandwich-id' value='{$rating->getChickenSandwichId()}'>
                        <button class='button' type='submit' id='delete-entry'
                        name='delete-entry' value='{$rating->getScore()}'>DELETE</button>"
                        . "<button class='button' type='submit' id='edit-entry'
                        name='edit-entry'>EDIT</button></form></div></div>";
            }           
                                
        ?> 

    </main>

    


    
