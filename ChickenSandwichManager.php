<?php

require_once('imagefileutil.php');
require_once('logofileutil.php');
require_once('ChickenSandwichResults.php');
require_once('ChickenSandwich.php');
require_once('DB.php');

/**
 * This class' purpose is to perform queries related to the chicken sandwich
 */
class ChickenSandwichManager {

    private $db;
    private $image_error;
    private $logo_error;
    private $image; 
    private $logo;
    private $rank = 0;

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
            return false;
        }
    }

	//This function's purpose is to read all entries
    public function readAll() {

        $sql = "SELECT * FROM chicken ORDER BY average DESC";
        return $this->executeQuery($sql);
    }

	//This function's purpose is to read the entry by id
    public function readById($id) {

        $sql = "SELECT * FROM chicken WHERE id=:id ORDER BY average DESC";
        return $this->executeQuery($sql, [':id' => $id]);
    }

	//This function's purpose is to get the chicken sandwich
    public function getChickenSandwich($id) {

        $results = $this->readById($id);
        return $results[0] ?? null;
    }

	//This function's purpose is to get the chicken sandwich score
    public function getChickenSandwichScore($id, $chicken_score) {

        $chicken = $this->getChickenSandwich($id);

        if ($chicken) {
            
            $this->updateScore($chicken->getId(), $chicken_score, $chicken->getEntries(), $chicken->getScore());
        }
    }

	//This function's purpose is to display all chicken sandwiches
    public function displayAllChickenSandwiches() {

        foreach ($this->readAll() as $chicken_data) {
            
            $this->rank++;
            (new ChickenSandwichResults())->display($chicken_data, $this->rank);
        }
    }

	//This function's purpose is to display the chicken sandwich
    public function displayChickenSandwich($id) {

        foreach ($this->readAll() as $chicken_data) {

            $this->rank++;

            if ($chicken_data->getId() == $id) {

                (new ChickenSandwichResults())->display($chicken_data, $this->rank);
            }
        }
    }

	//This function's purpose is to update the score
    public function updateScore($id, $chicken_score, $entries, $new_score) {

        $entries++;
        $new_score += $chicken_score;
        $average = $new_score / $entries;

        $sql = "UPDATE chicken SET score=:score, average=:average, entries=:entries WHERE id=:id";
        $params = [':id' => $id, ':score' => $new_score, ':average' => $average, ':entries' => $entries];

        $this->executeQuery($sql, $params, false);

        $this->displayChickenSandwich($id);
    }

	//This function's purpose is to update the score on the deletion of entry by user
    public function updateScoreOnDeletionOfUser($id, $score) {

        $chicken = $this->getChickenSandwich($id);

        if ($chicken) {

            $entries = $chicken->getEntries();
            $new_score = $chicken->getScore() - $score;
            $average = $new_score / --$entries;

            $sql = "UPDATE chicken SET score=:score, average=:average, entries=:entries WHERE id=:id";
            $params = [':id' => $id, ':score' => $new_score, ':average' => $average, ':entries' => $entries];

            $this->executeQuery($sql, $params, false);
        }
    }

    //This function's purpose is to validate images
    public function validateImages() {

        $this->image_error = validateImageFile();
        $this->logo_error = validateLogo();

        $this->image = addImageFileReturnPathLocation();
        $this->logo = addLogoImageFileReturnPathLocation();
    }

	//This function's purpose is to update the chicken sandwich
    public function update($id, $name, $source) {

        $this->validateImages();

        $sql = "UPDATE chicken SET name=:name, logo=:logo, image=:image, source=:source WHERE id=:id";
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

        $this->validateImages();

        $sql = "INSERT INTO chicken (name, logo, image, source) VALUES (:name, :logo, :image, :source)";
        $params = [':name' => $name, ':logo' => $this->logo, ':image' => $this->image, ':source' => $source];

        $this->executeQuery($sql, $params, false);

        $lastInsertId = $this->db->lastInsertId();

        $this->displayChickenSandwich($lastInsertId);
    }

	//This function's purpose is to validate the chicken sandwich, ensuring the name doesn't already exist
    public function validateChickenSandwich($name) {

		//Get the names
        $sandwiches = array_map(function($chicken_sandwich) {
            return $chicken_sandwich->getName();

        }, $this->readAll());

		//Return whether the name exists or not (true/false)
        return in_array($name, $sandwiches);
    }

	//This function's purpose is to delete an entry
    public function delete($id) {

        $sql = "DELETE FROM chicken WHERE id=:id";
        $params = [':id' => $id];
        $this->executeQuery($sql, $params, false);

        $this->displayAllChickenSandwiches();
    }
}
?>
