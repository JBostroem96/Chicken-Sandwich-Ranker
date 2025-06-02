<?php

require_once('image-file-util.php');
require_once('logo-file-util.php');
require_once('ChickenSandwich.php');
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
        public function displayAllChickenSandwiches() {

            foreach ($this->readAll() as $chicken_sandwich_data) {
                
                $this->rank++;
                displayChickenSandwichResults($chicken_sandwich_data, $this->rank);
            }
        }

        //This function's purpose is to display the chicken sandwich
        public function displayChickenSandwich($id) {

            foreach ($this->readAll() as $chicken_data) {

                $this->rank++;

                if ($chicken_data->getId() == $id) {

                    displayChickenSandwichResults($chicken_data, $this->rank);
                }
            }
        }

        //This function's purpose is to update the score
        public function updateScore($id, $chicken_sandwich_score, $entries, $new_score) {

            $entries++;
            $new_score += $chicken_sandwich_score;
            $average = $new_score / $entries;

            $sql = "UPDATE chicken_sandwich SET score=:score, average=:average, entries=:entries WHERE id=:id";
            $params = [':id' => $id, ':score' => $new_score, ':average' => $average, ':entries' => $entries];

            $this->executeQuery($sql, $params, false);

            $this->displayChickenSandwich($id);
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
        public function update($id, $name, $source) {

            if ($this->validateChickenSandwich($name)) {

                echo "Chicken sandwich with this name already exists.";
                return;
            }

            if ($this->validateImages()) {

                return;
            }

            $sql = "UPDATE chicken_sandwich SET name=:name, logo=:logo, image=:image, source=:source WHERE id=:id";
            $params = [':id' => $id, ':name' => $name, ':logo' => $this->logo, ':image' => $this->image, ':source' => $source];

            $this->executeQuery($sql, $params, false);

            $this->displayChickenSandwich($id);
        }

        //This function's purpose is to insert a new chicken sandwich
        public function insertChickenSandwich($name, $source) {

            if ($this->validateChickenSandwich($name)) {

                echo "Chicken sandwich with this name already exists.";
                return;
            }

            if ($this->validateImages()) {

                return;
            }

            $sql = "INSERT INTO chicken_sandwich (name, logo, image, source) VALUES (:name, :logo, :image, :source)";
            $params = [':name' => $name, ':logo' => $this->logo, ':image' => $this->image, ':source' => $source];

            $this->executeQuery($sql, $params, false);

            $lastInsertedId = $this->db->lastInsertId();

            $this->displayChickenSandwich($lastInsertedId);
        }

        //This function's purpose is to validate the chicken sandwich, ensuring the name doesn't already exist
        public function validateChickenSandwich($name) {

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

            $this->displayAllChickenSandwiches();
        }
    }
?>