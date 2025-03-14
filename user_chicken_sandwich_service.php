 
<?php
    
    require_once('authorizeaccess_user.php');
    require_once('UserChickenSandwichManager.php');
    require_once('ChickenSandwichManager.php');

    $http_verb = $_SERVER['REQUEST_METHOD'];
    $user_chicken_sandwich_manager = new UserChickenSandwichManager();
    $chicken_sandwich_manager = new ChickenSandwichManager();

//Using the http verb ...
switch ($http_verb) {

    case "POST":
        
        //If a score is being deleted
        if (isset($_POST['delete_entry'])) {

            
            $user_chicken_sandwich_manager->delete($_SESSION['id'], $_POST['chicken_id']);
            $chicken = $chicken_sandwich_manager->getChickenSandwich($_POST['chicken_id']);
            
            $user_chicken_sandwich_manager->updateScoreOnDelete($chicken, $_POST['delete_entry'], $_SESSION['id']);  
            
        //If the user edits their entry ...
        } elseif(isset($_POST['edit_entry'])) {

            $result = $user_chicken_sandwich_manager->readAll($_SESSION['id']);
            $user_chicken_sandwich_manager->displayUserChicken($result);

        //If the user clicks the edit score button
        } elseif (isset($_POST['edit_score'])) {
            
            $score = $_POST['score'];

            if (filter_var($score, FILTER_VALIDATE_INT) && $score >= 1 && $score <= 10) {

                $current_score = $user_chicken_sandwich_manager->getChickenSandwichScore($_SESSION['id'], $_POST['edit_score']);
                $chicken = $chicken_sandwich_manager->getChickenSandwich($_POST['edit_score']);
                $user_chicken_sandwich_manager->updateUserScore($_SESSION['id'], $chicken->getId(), $_POST['score']);
                $user_chicken_sandwich_manager->updateScore($_SESSION['id'], $chicken, $_POST['score'], $current_score);

            } else {

                echo "<p class='text-center text-danger'>Only 1-10 are allowed</p>";

                //Redirects the user to their ratings
                $user_chicken_sandwich_manager->displayUserChicken($user_chicken_sandwich_manager->readAll($_SESSION['id']));
            }
            

        } else {


            throw new Exception("Invalid HTTP POST request parameters.");
        }
    
        break;

        case "GET":

            //If the user views their scores
            if (isset($_GET['user_scores'])) {

                $result = $user_chicken_sandwich_manager->readAll($_SESSION['id']);
                $user_chicken_sandwich_manager->displayUserChicken($result);

            } else {

                throw new Exception("Invalid HTTP GET request parameters.");
            }

            break;
        default:
                        
        throw new Exception("Unsupported HTTP request.");
        break;
}
    
?>

