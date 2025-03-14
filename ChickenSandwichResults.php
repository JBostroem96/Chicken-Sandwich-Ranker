<?php

    require_once('pagetitles.php');
    $page_title = MR_RESULT_PAGE;

    require_once('headings.php');
    $heading = MR_RESULT_HEADING;
?>

<!DOCTYPE html>
<html>
    <?php require_once('head.php'); ?>
    
        <main class='mt-2'>
            <?php require_once('heading.php');          
            
                //This class' purpose is to display the results for the chicken sandwich
                class ChickenSandwichResults {

                    //display chicken sandwich and the permission-related features
                    public function display($chicken_sandwich, $rank) {
                        
                        echo "<h1>$rank.</h1>"
                            . "<div class='score'>" 
                            . "<div class='styling'><p class='text-white fw-bold'>RATED: <br>" 
                            . round($chicken_sandwich->getAverage()) . "/10</p><p class='text-white fw-bold'>" 
                            . "TOTAL SCORE: <br> " . $chicken_sandwich->getScore() . "</p>"
                            . "<p class='text-white fw-bold'>NUMBER OF RATINGS: " 
                            . $chicken_sandwich->getEntries() . "</p></div>"
                            . "<table id='results'>" 
                            . "<tr><td class='profile-details'>" . "<img src=" . $chicken_sandwich->getLogo()  
                            . " class='logo'"  
                            . "</td><td class='profile-details'><img src=" . $chicken_sandwich->getImage()  
                            . " class='image'" .
                                "alt='chicken sandwhich'></td></tr><tr><td class='profile-details'>" 
                            . "<h2>" . $chicken_sandwich->getName() . "</h2>"
                            . " By: "
                            . "</td></tr><tr><td>";
                                    
                        if (isset($_SESSION['access_privileges'])) {

                            echo "<form action='chicken_sandwich_service.php' method='POST'>
                                <input type='hidden' name='id' value='{$chicken_sandwich->getId()}'>
                                <input type='numeric' name='score' pattern='[1-9]|10' required>
                                <br><button class='button' type='submit' id='submit_score' value='{$chicken_sandwich->getName()}'
                                    name='submit_score'>RATE ME!</button></form><p>Only 1-10 is allowed, one rating per account</p>";

                            if ($_SESSION['access_privileges'] == 'admin') {

                                echo "<form action='chicken_sandwich_service.php' method='POST'>
                                    <input type='hidden' name='id' value='{$chicken_sandwich->getId()}'>
                                    <button class='button' type='submit' id='delete_chicken'
                                    name='delete_chicken'>DELETE</button>
                                    <button class='button' type='submit' id='edit_chicken'
                                    name='edit_chicken'>EDIT</button></form>";
                            } 
                        }

                        echo "<tr><td>Source: " 
                            . $chicken_sandwich->getSource() 
                            . '</td></tr>'              
                            .  "</form></table></div>'";                           
                    }
                }
    
            ?>  
        </main>

        <?php require_once("footer.php"); ?>

    </body>   
</html>


