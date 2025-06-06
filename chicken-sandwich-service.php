 
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
		
			//If the user submits a new sandwich ...
			if (isset($_POST['enter-chicken-sandwich'])) {

				$user_chicken_sandwich = $user_chicken_sandwich_manager->readAll($_SESSION['id']);

				//If it doesn't already exist ...
				if ($chicken_sandwich_manager->checkMatchingChickenSandwichName($_POST['name']) == false) {

					$chicken_sandwich_manager->insertChickenSandwich($_POST['name'], $_POST['source']);
				
				//otherwise ...
				} else {

					require_once('enter-chicken-sandwich-form.php');
				}
			
			//If the admin deletes a sandwich ...
			} elseif(isset($_POST['delete-chicken'])) {

				$chicken_sandwich_manager->delete($_POST['id']);
			
			//If the admin edits a sandwich ...	
			} elseif (isset($_POST['edit-chicken-sandwich'])) {
				
				//Bring up the form
				require_once('enter-chicken-sandwich-form.php');
				
			//If the admin submits a sandwich edit ...	
			} elseif (isset($_POST['chicken-sandwich-update'])) {

				//If the sandwich doesn't already exist ...
				if ($chicken_sandwich_manager->checkMatchingChickenSandwichName($_POST['name']) == false) {

					$chicken_sandwich_manager->updateChickenSandwich($_POST['chicken-sandwich-update'], $_POST['name'], $_POST['source']);
					$user_chicken_sandwich_manager->updateUserEntry($_POST['chicken-sandwich-update'], $_POST['name']);
				
				//otherwise ...
				} else {
					
					require_once('enter-chicken-sandwich-form.php');
				}

			} else {

				
				throw new Exception("Invalid HTTP POST request parameters.");

			}
		
			break;

			case "GET":

				//If all sandwiches are being searched ...
				if (isset($_GET['view-all'])) {

					if (isset($_SESSION['id'])) {
						
						$ratings = $chicken_sandwich_manager->findChickenSandwichRatings($chicken_sandwich_manager->getUserChickenSandwiches());
						$chicken_sandwich_manager->displayAllChickenSandwiches($ratings, null, null);

					} else {

						$chicken_sandwich_manager->displayAllChickenSandwiches(null, null, null);
					}
					  
				//If a specifc sandwich is being searched ...
				} elseif (isset($_GET['search-term']) AND isset($_GET['search-type'])) {	
					
					$search_term = $_GET['search-term'];
					$search_type = $_GET['search-type'];

					if (isset($_SESSION['id'])) {

						$ratings = $chicken_sandwich_manager->findChickenSandwichRatings($chicken_sandwich_manager->getUserChickenSandwiches());
						$chicken_sandwich_manager->displayAllChickenSandwiches($ratings, $search_term, $search_type);

					} else {

						$chicken_sandwich_manager->displayAllChickenSandwiches(null, $search_term, $search_type);
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
	
