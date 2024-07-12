 
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

        //If the user edits their score
        } elseif (isset($_POST['edit_score'])) {

            $score = $user_chicken_sandwich_manager->getChickenSandwichScore($_SESSION['id'], $_POST['edit_score']);
            $chicken = $chicken_sandwich_manager->getChickenSandwich($_POST['edit_score']);
            $user_chicken_sandwich_manager->updateUserScore($_SESSION['id'], $chicken->getId(), $_POST['score']);
            $user_chicken_sandwich_manager->updateScore($_SESSION['id'], $chicken, $_POST['score'], $score);

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

