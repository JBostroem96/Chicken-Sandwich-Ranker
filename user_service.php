 
<?php

require_once('authorizeaccess_user.php');
require_once('UserManager.php');
require_once('User.php');
require_once('UserChickenSandwichManager.php');
require_once('ChickenSandwichManager.php');

$http_verb = $_SERVER['REQUEST_METHOD'];
$user_manager = new UserManager();
$user_chicken_sandwich_manager = new UserChickenSandwichManager();
$chicken_sandwich_manager = new ChickenSandwichManager();

//Using the http verb ...
switch ($http_verb) {

    case "POST":
        
        //If the user is being deleted ...
        if (isset($_POST['delete_user'])) {

            //Get all user entries
            foreach($user_chicken_sandwich_manager->readAll($_SESSION['id']) as $result) {

                //Update the chicken sandwich score, passing over the chicken sandwich id and the user score
                $chicken_sandwich_manager->updateScoreOnDeletionOfUser($result->getChicken_id(), $result->getScore());
            }

            //Delete user
            $user_manager->delete($_SESSION['id']);

            require_once('logout.php');
        
        //If the user clicks on edit password
        } elseif(isset($_POST['edit_user'])) {

            //Read use
            $user_manager->readById($_SESSION['id']);
        
        //if the user clicks edit password
        } elseif (isset($_POST['edit_password'])) {

            //If the log in is successful ...
            if ($user_manager->login($_SESSION['username'], $_POST['currentPassword']) == true) {

                //And if the new password is the same as the repeated password ...
                if ($_POST['newPassword'] == $_POST['repeatPassword']) {

                    //Update the password
                    $user_manager->updatePassword($_POST['newPassword'], $_SESSION['id']);

                    echo "<h1 class='text-success'>You successfully updated your password</h1>";

                } else {

                    echo "<h1 class='text-danger'>Your re-entered password is not correct.</h1>";
                }
                
            }

        } else {


            throw new Exception("Invalid HTTP POST request parameters.");
        }
    
        break;

        case "GET":

            //If the user views their info ...
            if (isset($_GET['userInfo'])) {

                //Read user
                $user_manager->readById($_SESSION['id']);
            

            } else {

                throw new Exception("Invalid HTTP GET request parameters.");
            }

            break;
        default:
                        
        throw new Exception("Unsupported HTTP request.");
        break;
}
    
?>

