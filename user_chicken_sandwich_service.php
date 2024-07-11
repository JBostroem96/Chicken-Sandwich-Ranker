 
<?php
    session_start();
    require_once('UserChickenSandwichManager.php');
    require_once('ChickenSandwichManager.php');

    $http_verb = $_SERVER['REQUEST_METHOD'];
    $user_chicken_sandwich_manager = new UserChickenSandwichManager();
    $chicken_sandwich_manager = new ChickenSandwichManager();

//Using the http verb ...
switch ($http_verb) {

    case "POST":
        
        //If a new score is submitted ...
        if (isset($_POST['delete_entry'])) {

            //if the user has not rated this yet ...
            $user_chicken_sandwich_manager->delete($_SESSION['id'], $_POST['chicken_id']);
            $chicken = $chicken_sandwich_manager->getChickenSandwich($_POST['chicken_id']);
            
            $user_chicken_sandwich_manager->updateScoreOnDelete($chicken, $_POST['delete_entry'], $_SESSION['id']);  
            
        //If the user submits a new sandwich ...
        } elseif(isset($_POST['edit_entry'])) {

            $result = $user_chicken_sandwich_manager->readAll($_SESSION['id']);
            $user_chicken_sandwich_manager->displayUserChicken($result);

        //If the admin deletes a sandwich ...
        } elseif(isset($_POST['delete_chicken'])) {

            $chicken_sandwich_manager->delete($_POST['id']);
        
        //If the admin edits a sandwich ...	
        } elseif (isset($_POST['edit_score'])) {

            $score = $user_chicken_sandwich_manager->getChickenSandwichScore($_SESSION['id'], $_POST['edit_score']);
            $chicken = $chicken_sandwich_manager->getChickenSandwich($_POST['edit_score']);
            $user_chicken_sandwich_manager->updateUserScore($_SESSION['id'], $chicken->getId(), $_POST['score']);
            $user_chicken_sandwich_manager->updateScore($_SESSION['id'], $chicken, $_POST['score'], $score);
            
        //If the admin submits a sandwhich edit ...	

        } else {


            throw new Exception("Invalid HTTP POST request parameters.");
        }
    
        break;

        case "GET":

            //If the user views their info ...
            if (isset($_GET['user_scores'])) {

                $result = $user_chicken_sandwich_manager->readAll($_SESSION['id']);
                $user_chicken_sandwich_manager->displayUserChicken($result);
            
            //If a specifc sandwich is being searched ...

            } else {

                throw new Exception("Invalid HTTP GET request parameters.");
            }

            break;
        default:
                        
        throw new Exception("Unsupported HTTP request.");
        break;
}
    
?>

