 
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

				//If it doesn't already exist ...
				if ($chicken_sandwich_manager->validateChickenSandwich($_POST['name']) == false) {

					$chicken_sandwich_manager->insertChickenSandwich($_POST['name'], $_POST['source']);
				
				//otherwise ...
				} else {

					require_once('enter-chicken-sandwich-form.php');
					echo "<p>That chicken sandwich already exists. Please enter a different one.</p>";
				}
			
			//If the admin deletes a sandwich ...
			} elseif(isset($_POST['delete-chicken'])) {

				$chicken_sandwich_manager->delete($_POST['id']);
			
			//If the admin edits a sandwich ...	
			} elseif (isset($_POST['edit-chicken-sandwich'])) {
				
				//Bring up the form
				require_once('enter-chicken-sandwich-form.php');
				
			//If the admin submits a sandwhich edit ...	
			} elseif (isset($_POST['id'])) {

				//If the sandwich doesn't already exist ...
				if ($chicken_sandwich_manager->validateChickenSandwich($_POST['name']) == false) {

					$chicken_sandwich_manager->update($_POST['id'], $_POST['name'], $_POST['source']);
					$user_chicken_sandwich_manager->updateUserEntry($_POST['id'], $_POST['name']);
				
				//otherwise ...
				} else {
					
					require_once('enter-chicken-sandwich-form.php');
					echo "<p>That chicken sandwich already exists. Please enter a different one.</p>";
				}

			} else {

				
				throw new Exception("Invalid HTTP POST request parameters.");

			}
		
			break;

			case "GET":

				//If all sandwiches are being searched ...
				if (isset($_GET['view-all'])) {

					if (isset($_SESSION['id'])) {

						$user_chicken = $user_chicken_sandwich_manager->readAll($_SESSION['id']);
						$chicken_sandwich_manager->displayAllChickenSandwiches($user_chicken);

					} else {

						
						$chicken_sandwich_manager->displayAllChickenSandwiches();
					}
			
                    
				//If a specifc sandwich is being searched ...
				} elseif (isset($_GET['search-term']) AND isset($_GET['search-type'])) {	
					
					//Loop through all sandwiches
					foreach ($chicken_sandwich_manager->readAll() as $chicken_data) {

						//using the search type ...
						switch ($_GET['search-type']) {

							//If it equals a name search ...
							case 'name':
								if ($chicken_data->getName() == $_GET['search-term']) {

									$chicken_sandwich_manager->displayChickenSandwich($chicken_data->getId());

								}

								break;
							//else, if it equals a 'score' search ...
							case 'score':
								if ($chicken_data->getScore() == $_GET['search-term']) {

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
	
