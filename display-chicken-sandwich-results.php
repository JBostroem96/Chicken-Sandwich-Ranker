<?php

    require_once('page-titles.php');
    $page_title = MR_RESULT_PAGE;

    require_once('headings.php');
    $heading = MR_RESULT_HEADING;
    
    require_once('head.php');

    require_once('heading.php');

    //display chicken sandwich and the permission-related features
    function displayChickenSandwichResults($chicken_sandwich, $rank, $foundRating = null) {
                              
        echo "<h2>$rank.</h2>"
            . "<div class='score'>" 
            . "<div class='styling'><p class='text-white fw-bold'>RATED: <br>" 
            . round($chicken_sandwich->getAverage()) . "/10</p><p class='text-white fw-bold'>" 
            . "TOTAL SCORE: <br> " . $chicken_sandwich->getScore() . "</p>"
            . "<p class='text-white fw-bold'>NUMBER OF RATINGS: " 
            . $chicken_sandwich->getEntries() . "</p></div>"
            . "<table id='results'>" 
            . "<tr><td class='profile-details'>" . "<img src=" . $chicken_sandwich->getLogo()  
            . " class='logo'"  
            . "</td><td class='profile-details'>" . "<img src=" . $chicken_sandwich->getImage()  
            . " class='image'" 
            . "alt='chicken sandwhich'></td></tr><tr><td class='profile-details'>" 
            . "<h2>" 
            . $chicken_sandwich->getName() 
            . "</h2>"
            . "</td></tr><tr><td>";
                                                
        if (isset($_SESSION['access_privileges'])) {

            if ($foundRating == null || $foundRating->getChickenSandwichId() != $chicken_sandwich->getId()) {

                echo "<form action='user-chicken-sandwich-service.php' method='POST'>
                <input type='hidden' name='id' value='{$chicken_sandwich->getId()}'>
                <label for='score' class='mt-5'>Score</label><br>
                <input type='numeric' name='score' class='mb-3' pattern='[1-9]|10' required>
                <br>
                <label for='review'>Review</label><br>
                <textarea rows='2' cols='20' name='review' id='review'></textarea><br>
                <button class='button' type='submit' id='submit-score' value='{$chicken_sandwich->getName()}'
                name='submit-score'>RATE ME!</button><br>
                </form>
                <p>Only 1-10 is allowed</p>";

            } else {

                echo "<h2 class='text-success fw-bold'>RATED</h2>";
                    
            }
                
            if ($_SESSION['access_privileges'] == 'admin') {

                echo "<form action='chicken-sandwich-service.php' method='POST'>
                    <input type='hidden' name='id' value='{$chicken_sandwich->getId()}'>
                    <button class='button' type='submit' id='delete-chicken'
                    name='delete-chicken'>DELETE</button>
                    <button class='button' type='submit' id='edit-chicken'
                    name='edit-chicken-sandwich'>EDIT</button></form>";
            }

        } else {

            echo "<h2 class='fw-bold text-black mt-3'>Login to rate!</h2>";
        }
                
        echo "<tr><td>Source: " 
            . $chicken_sandwich->getSource() 
            . '</td></tr>'              
            .  "</form></table></div>";                           
    }
?>  
    </main>

<?php require_once("footer.php"); ?>

    


