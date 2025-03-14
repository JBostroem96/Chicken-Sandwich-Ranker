 
<?php

	session_start();
	require_once('ChickenSandwichManager.php');
	require_once('UserChickenSandwichManager.php');
	
	$http_verb = $_SERVER['REQUEST_METHOD'];
	$chicken_sandwich_manager = new ChickenSandwichManager();
	$user_chicken_sandwich_manager = new UserChickenSandwichManager();
	

	//Using the http verb ...
	switch ($http_verb) {

		case "POST":
			
			//If a new score is submitted ...
			if (isset($_POST['submit_score'])) {
				
				$score = $_POST['score'];
				
				//Validates that the submitted score is an int and that its score is between 1 and 10
				if (filter_var($score, FILTER_VALIDATE_INT) && $score >= 1 && $score <= 10) {

					//if the user has not rated this yet ...
					if ($user_chicken_sandwich_manager->findRating($_SESSION['id'], $_POST['id']) == false) {

						$chicken_id = $_POST['id'];
						$name = $_POST['submit_score'];

						$user_chicken_sandwich_manager->setRating($_SESSION['id'], $chicken_id, $score, $name);
						$chicken_sandwich_manager->getChickenSandwichScore($chicken_id, $score);
					
					//otherwise ...
					} else {

						echo "<p class='text-center text-danger'>You have already rated this chicken</p>";
						$chicken_sandwich_manager->displayChickenSandwich($_POST['id']);
						
					}	

				} else {

					echo "<p class='text-center text-danger'>Only 1-10 are allowed.</p>";
					$chicken_sandwich_manager->displayChickenSandwich($_POST['id']);
				}
		
			//If the user submits a new sandwich ...
			} elseif(isset($_POST['enter_chicken'])) {

				//If it doesn't already exist ...
				if ($chicken_sandwich_manager->validateChickenSandwich($_POST['name']) == false) {

					$chicken_sandwich_manager->insertChickenSandwich($_POST['name'], $_POST['source']);
				
				//otherwise ...
				} else {

					require_once('form.php');
					echo "<p>That chicken sandwich already exists. Please enter a different one.</p>";
				}
			
			//If the admin deletes a sandwich ...
			} elseif(isset($_POST['delete_chicken'])) {

				$chicken_sandwich_manager->delete($_POST['id']);
			
			//If the admin edits a sandwich ...	
			} elseif (isset($_POST['edit_chicken'])) {
				
				//Bring up the form
				require_once('form.php');
				
			//If the admin submits a sandwhich edit ...	
			} elseif (isset($_POST['id'])) {

				//If the sandwich doesn't already exist ...
				if ($chicken_sandwich_manager->validateChickenSandwich($_POST['name']) == false) {

					$chicken_sandwich_manager->update($_POST['id'], $_POST['name'], $_POST['source']);
					$user_chicken_sandwich_manager->updateUserEntry($_POST['id'], $_POST['name']);
				
				//otherwise ...
				} else {
					
					require_once('form.php');
					echo "<p>That chicken sandwich already exists. Please enter a different one.</p>";
				}

			} else {

				
				throw new Exception("Invalid HTTP POST request parameters.");

			}
		
			break;

			case "GET":

				//If all sandwiches are being searched ...
				if (isset($_GET['viewAll'])) {

                    $chicken_sandwich_manager->displayAllChickenSandwiches();
				
				//If a specifc sandwich is being searched ...
				} elseif (isset($_GET['searchTerm']) AND isset($_GET['searchType'])) {	
					
					//Loop through all sandwiches
					foreach ($chicken_sandwich_manager->readAll() as $chicken_data) {

						//using the search type ...
						switch ($_GET['searchType']) {

							//If it equals a name search ...
							case 'name':
								if ($chicken_data->getName() == $_GET['searchTerm']) {

									$chicken_sandwich_manager->displayChickenSandwich($chicken_data->getId());

								}

								break;
							//else, if it equals a 'score' search ...
							case 'score':
								if ($chicken_data->getScore() == $_GET['searchTerm']) {

									$chicken_sandwich_manager->displayChickenSandwich($chicken_data->getId());
								}

								break;
						}
                    }

				} else {

					header("Location: index.php");
        			exit();
				}
	
				break;
			default:
							
			throw new Exception("Unsupported HTTP request.");
			break;
	}
		
?>
	
