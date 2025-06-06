<?php

require_once('image-file-util.php');
require_once('logo-file-util.php');
require_once('ChickenSandwich.php');
require_once('UserChickenSandwichManager.php');
require_once('DB.php');
require_once('display-chicken-sandwich-results.php');

    /**
     * This class' purpose is to perform queries related to the chicken sandwich
     */
    class ChickenSandwichManager {

        private $db;
        private $rank = 0;
        private $image;
        private $logo;
        private $image_error;
        private $logo_error;
        private $foundRating;

        //This function's purpose is to be the constructor, which connects to the DB
        public function __construct() {

            $this->db = (new DB())->connect();
        }

        //This function's purpose is to execute the queries
        private function executeQuery($sql, $params = [], $fetchAll = true) {

            try {

                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $fetchAll ? $query->fetchAll(PDO::FETCH_CLASS, 'ChickenSandwich') : true;

            } catch (Exception $ex) {

                echo "{$ex->getMessage()}<br/>\n";
            }
        }

        //This function's purpose is to read all entries
        public function readAll() {

            $sql = "SELECT * FROM chicken_sandwich ORDER BY average DESC";
            return $this->executeQuery($sql);
        }

        //This function's purpose is to read the entry by id
        public function readById($id) {

            $sql = "SELECT * FROM chicken_sandwich WHERE id=:id ORDER BY average DESC";
            return $this->executeQuery($sql, [':id' => $id]);
        }

        //This function's purpose is to get the chicken sandwich
        public function getChickenSandwich($id) {

            $results = $this->readById($id);
            return $results[0] ?? null;
        }

        //This function's purpose is to get the chicken sandwich score
        public function getChickenSandwichScore($id, $chicken_sandwich_score) {

            $chicken_sandwich = $this->getChickenSandwich($id);

            if ($chicken_sandwich) {
                
                $this->updateScore($chicken_sandwich->getId(), $chicken_sandwich_score, $chicken_sandwich->getEntries(), $chicken_sandwich->getScore());
            }
        }

        //This function's purpose is to display all chicken sandwiches
        public function displayAllChickenSandwiches($ratings = null, $search_term = null, $search_type = null) {

            foreach ($this->readAll() as $chicken_sandwich) {

                $this->rank++;
                
                if ($ratings !== null) {

                    $this->foundRating = $ratings[$chicken_sandwich->getId()] ?? null;
                } 

                if (isset($search_term) && isset($search_type)) {

                    $this->searchChickenSandwich($chicken_sandwich, $search_term, $search_type);

                } else {

                    displayChickenSandwichResults($chicken_sandwich, $this->rank, $this->foundRating);

                }
            }
        }

        //this function's purpose is to search the chicken sandwich by search term
        public function searchChickenSandwich($chicken_sandwich, $search_term, $search_type) {
            
            //using the search type ...
			switch ($search_type) {

				//If it equals a name search ...
				case 'name':

				    if ($chicken_sandwich->getName() === $search_term) {

						displayChickenSandwichResults($chicken_sandwich, $this->rank, $this->foundRating);
					}

					break;

				//else, if it equals a 'score' search ...
				case 'score':

					if ($chicken_sandwich->getScore() == $search_term) {

						displayChickenSandwichResults($chicken_sandwich, $this->rank, $this->foundRating);
					}

					break;
            }

        }
            

        //this function's purpose is to find the user's rated chicken sandwiches
        public function findChickenSandwichRatings($user_chicken_sandwich): array {

            //prepare ratings
            $ratings = [];

            foreach ($user_chicken_sandwich as $user_chicken_entry) {

                //assign the ratings
                $ratings[$user_chicken_entry->getChickenSandwichId()] = $user_chicken_entry;
            }

            return $ratings;
        }


        public function assignRating() {

            foreach ($this->readAll() as $chicken_sandwich) {

                $this->rank++;
                
                //Assign any found ratings; if not, null.
                $foundRating = $ratings[$chicken_sandwich->getId()] ?? null;

                displayChickenSandwichResults($chicken_sandwich, $this->rank, $foundRating);
            }
        }


        //This function's purpose is to update the score
        public function updateScore($chicken_sandwich, $chicken_sandwich_score, $entries, $new_score) {

            $entries++;
            $new_score += $chicken_sandwich_score;
            $average = $new_score / $entries;

            $sql = "UPDATE chicken_sandwich SET score=:score, average=:average, entries=:entries WHERE id=:id";
            $params = [':id' => $chicken_sandwich, ':score' => $new_score, ':average' => $average, ':entries' => $entries];

            $this->executeQuery($sql, $params, false);
            
            $this->displayAllChickenSandwiches($this->getUserChickenSandwiches());

        } 


        //this function's purpose is to return the user's chicken sandwiches
        public function getUserChickenSandwiches() {

            return (new UserChickenSandwichManager())->readAll($_SESSION['id']);
        }

        //This function's purpose is to update the score on the deletion of entry by user
        public function updateScoreOnDeletionOfUser($id, $score) {

            $chicken_sandwich = $this->getChickenSandwich($id);

            if ($chicken_sandwich) {

                $entries = $chicken_sandwich->getEntries();

                if ($entries <= 1) {

                    $average = 0;
                    $entries = 0;
                    $new_score = 0;

                } else {

                    $entries--;
                    $new_score = $chicken_sandwich->getScore() - $score;
                    $average = $new_score / $entries;
                }

                $sql = "UPDATE chicken_sandwich SET score=:score, average=:average, entries=:entries WHERE id=:id";
                $params = [':id' => $id, ':score' => $new_score, ':average' => $average, ':entries' => $entries];

                $this->executeQuery($sql, $params, false);
            }
        }

        //This function's purpose is to validate the images
        public function validateImages() {

            $error = false;

            $image = $_FILES['image'];
            $logo = $_FILES['logo'];

            $this->image_error = validateImageFile($image);
            $this->logo_error = validateLogoFile($logo);

            $this->image = addImageFileReturnPathLocation($image);
            $this->logo = addLogoFileReturnPathLocation($logo);

            if (!empty($this->image_error)) {

                echo "<p class='text-danger text-center'>{$this->image_error}</p>";
                $error = true;
            }

            if (!empty($this->logo_error)) {

                echo "<p class='text-danger text-center'>{$this->logo_error}</p>";
                $error = true;
            }

            if (empty($this->image)) {

                echo "<p class='text-danger text-center'>There was an error uploading this image</p>";
                $error = true;
            }

            if (empty($this->logo)) {

                echo "<p class='text-danger text-center'>There was an error uploading this logo</p>";
                $error = true;
            }

            return $error;
        }

        //This function's purpose is to update the chicken sandwich
        public function updateChickenSandwich($id, $name, $source) {

            if ($this->validateImages()) {

                return;
            }

            $sql = "UPDATE chicken_sandwich SET name=:name, logo=:logo, image=:image, source=:source WHERE id=:id";
            $params = [':id' => $id, ':name' => $name, ':logo' => $this->logo, ':image' => $this->image, ':source' => $source];

            $this->executeQuery($sql, $params, false);

            $this->displayAllChickenSandwiches($this->getUserChickenSandwiches());
        }

        //This function's purpose is to insert a new chicken sandwich
        public function insertChickenSandwich($name, $source) {

            if ($this->validateImages()) {

                return;
            }

            $sql = "INSERT INTO chicken_sandwich (name, logo, image, source) VALUES (:name, :logo, :image, :source)";
            $params = [':name' => $name, ':logo' => $this->logo, ':image' => $this->image, ':source' => $source];

            $this->executeQuery($sql, $params, false);

            $this->displayAllChickenSandwiches($this->getUserChickenSandwiches());
        }

        //This function's purpose is to validate the chicken sandwich, ensuring the name doesn't already exist
        public function checkMatchingChickenSandwichName($name) {

            //Get the names
            $chicken_sandwiches = array_map(function($chicken_sandwich) {

                return $chicken_sandwich->getName();

            }, $this->readAll());

            //Return whether the name exists or not (true/false)
            return in_array($name, $chicken_sandwiches);
        }

        //This function's purpose is to delete an entry
        public function delete($id) {

            $sql = "DELETE FROM chicken_sandwich WHERE id=:id";
            $params = [':id' => $id];
            $this->executeQuery($sql, $params, false);

            $this->displayAllChickenSandwiches($this->getUserChickenSandwiches());
        }
    }
?>