 
<?php
    
    require_once('authorize-user-access.php');
    require_once('UserChickenSandwichManager.php');
    require_once('ChickenSandwichManager.php');

    $http_verb = $_SERVER['REQUEST_METHOD'];
    $user_chicken_sandwich_manager = new UserChickenSandwichManager();
    $chicken_sandwich_manager = new ChickenSandwichManager();

//Using the http verb ...
switch ($http_verb) {

    case "POST":
        
        //If a new score is submitted ...
		if (isset($_POST['submit-score']))  {
				
			$score = $_POST['score'];
				
			//Validates that the submitted score is an int and that its score is between 1 and 10
			if (filter_var($score, FILTER_VALIDATE_INT) && $score >= 1 && $score <= 10) {
                
				//if the user has not rated this yet ...
				if ($user_chicken_sandwich_manager->findRating($_SESSION['id'], $_POST['id']) == false) {

					$chicken_sandwich = $_POST['id'];
                    
					$name = $_POST['submit-score'];

					if (isset($_POST['review'])) {

                        $user_chicken_sandwich_manager->setReview($_SESSION['id'], $chicken_sandwich, $score, $name, $_POST['review']);
					    
                    } else {

                        $user_chicken_sandwich_manager->setReview($_SESSION['id'], $chicken_sandwich, $score, $name, null);
                    }

                    $chicken_sandwich_manager->getChickenSandwichScore($chicken_sandwich, $score);
					
				//otherwise ...
				} else {

					echo "<p class='text-center text-danger'>You have already rated this chicken</p>";
					$chicken_sandwich_manager->displayChickenSandwich($_POST['id']);
						
				}	

			} else {

				echo "<p class='text-center text-danger'>Only 1-10 are allowed.</p>";
				$chicken_sandwich_manager->displayChickenSandwich($_POST['id']);
			}
        
            
        //If a score is being deleted
        } elseif (isset($_POST['delete-entry'])) {

            $user_chicken_sandwich_manager->delete($_SESSION['id'], $_POST['chicken-sandwich-id']);
            $chicken_sandwich = $chicken_sandwich_manager->getChickenSandwich($_POST['chicken-sandwich-id']);
                
            $user_chicken_sandwich_manager->updateScoreOnDelete($chicken_sandwich, $_POST['delete-entry'], $_SESSION['id']);  
            
        //If the user edits their entry ...
        } elseif(isset($_POST['edit-entry'])) {

            $result = $user_chicken_sandwich_manager->readAll($_SESSION['id']);
            $user_chicken_sandwich_manager->displayUserChicken($result);

        //If the user clicks the edit score button
        } elseif (isset($_POST['edit-score'])) {
            
            $score = $_POST['score'];

            //Validates that the submitted score is an int and that its score is between 1 and 10
            if (filter_var($score, FILTER_VALIDATE_INT) && $score >= 1 && $score <= 10) {

                $current_score = $user_chicken_sandwich_manager->getChickenSandwichScore($_SESSION['id'], $_POST['edit-score']);
                $chicken_sandwich = $chicken_sandwich_manager->getChickenSandwich($_POST['edit-score']);
                $user_chicken_sandwich_manager->updateUserScore($_SESSION['id'], $chicken_sandwich->getId(), $_POST['score']);
                $user_chicken_sandwich_manager->updateScore($_SESSION['id'], $chicken_sandwich, $_POST['score'], $current_score);

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
            if (isset($_GET['user-scores'])) {

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

