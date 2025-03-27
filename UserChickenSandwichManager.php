<?php

require_once('UserChickenSandwich.php');
require_once('UserRatingResults.php');
require_once('DB.php');

/**
 * This class' purpose is to perform functionalities related to the different user chicken queries
 */
class UserChickenSandwichManager {

    private $db;
    private const CLASS_USER_CHICKEN_SANDWICH = 'UserChickenSandwich';

    //this function's purpose is to be the constructor of this class and connect to the database
    public function __construct() {

        $this->db = (new DB())->connect();
    }

   	//this function's purpose is to read all of a user's entries
    public function readAll($user_id) {

        $sql = "SELECT * FROM user_chicken_sandwich WHERE user_id=:user_id";
        return $this->executeQuery($sql, [':user_id' => $user_id], self::CLASS_USER_CHICKEN_SANDWICH);
    }

    //this function's purpose is to read a user's entry by id
    public function readById($user_id, $chicken_sandwich_id) {

        $sql = "SELECT * FROM user_chicken_sandwich WHERE user_id=:user_id AND chicken_id=:chicken_id";
        return $this->executeQuery($sql, [':user_id' => $user_id, ':chicken_id' => $chicken_sandwich_id], self::CLASS_USER_CHICKEN_SANDWICH);
    }

    //this function's purpose is to display a user's ratings
    public function displayUserChicken($user_chicken_sandwich_entry) {

        foreach ($user_chicken_sandwich_entry as $chicken_data) {

			//display ratings
            (new UserRatingResults())->display($chicken_data);
        }
    }

    //this function's purpose is to update the chicken sandwich score when a user edits its own rating
    public function updateScore($user_id, $chicken_sandwich, $new_score, $old_score) {

        $entries = $chicken_sandwich->getEntries();
		$current_total_score = $chicken_sandwich->getScore();
		$average = $chicken_sandwich->getAverage();

        //Subtract the old score, removing it
		$current_total_score -= $old_score;
        //Add the new score
		$current_total_score += $new_score;

        //Calculate the new average
        $new_average = $current_total_score / $entries;

        $sql = "UPDATE chicken_sandwich SET score=:score, average=:average WHERE id=:id";
        $params = [':id' => $chicken_sandwich->getId(), ':score' => $current_total_score, ':average' => $new_average];
        $this->executeQuery($sql, $params);

        $this->displayUserChicken($this->readAll($user_id));
    }

    //this function's purpose is to update the user rating score when they edit it
    public function updateUserScore($user_id, $chicken_sandwich_id, $new_score) {

        $sql = "UPDATE user_chicken_sandwich SET score=:score WHERE user_id=:user_id AND chicken_id=:chicken_id";
        $params = [':chicken_id' => $chicken_sandwich_id, ':user_id' => $user_id, ':score' => $new_score];
        $this->executeQuery($sql, $params);
    }

    //this function's purpose is to update the chicken sandwich name for users
    public function updateUserEntry($chicken_sandwich_id, $name) {

        $sql = "UPDATE user_chicken_sandwich SET name=:name WHERE chicken_id=:chicken_id";
        $params = [':chicken_id' => $chicken_sandwich_id, ':name' => $name];
        $this->executeQuery($sql, $params);
    }

    //this function's purpose is to see if the user has already submitted a rating
    public function findRating($user_id, $chicken_sandwich_id) {

        $sql = "SELECT * FROM user_chicken_sandwich WHERE user_id=:user_id AND chicken_id=:chicken_id";
        $params = [':user_id' => $user_id, ':chicken_id' => $chicken_sandwich_id];
        $results = $this->executeQuery($sql, $params);

		//if the results equal 1, then true; otherwise, false
        return $results ? count($results) === 1 : false;
    }

    // this function's purpose is to get the chicken sandwich score by user_id and chicken_id
    public function getChickenSandwichScore($user_id, $chicken_sandwich_id) {

        $chicken = $this->readById($user_id, $chicken_sandwich_id);
		
        return $chicken[0]->getScore();
    }

	// This function's purpose is to update the score on user chicken deletion
	public function updateScoreOnDelete($chicken_sandwich, $score, $user_id) {

		$entries = $chicken_sandwich->getEntries();
        --$entries; 
		$chicken_sandwich_score = $chicken_sandwich->getScore() - $score; 

		$entries > 0 ? $average = $chicken_sandwich_score / $entries : $average = 0;   

		$sql = "UPDATE chicken_sandwich SET score=:score, average=:average, entries=:entries WHERE id=:id";
		$params = [':id' => $chicken_sandwich->getId(), ':score' => $chicken_sandwich_score, ':average' => $average, ':entries' => $entries];

		$this->executeQuery($sql, $params);

		$this->displayUserChicken($this->readAll($user_id));
	}


    // this function's purpose is to delete the user chicken entry by the chicken and user id
    public function delete($user_id, $chicken_sandwich_id) {

        $sql = "DELETE FROM user_chicken_sandwich WHERE user_id=:user_id AND chicken_id=:chicken_id";
        $params = [':user_id' => $user_id, ':chicken_id' => $chicken_sandwich_id];
        $this->executeQuery($sql, $params);
    }

    // this function's purpose is to insert the user rating for a given chicken sandwich
    public function setRating($user_id, $chicken_sandwich_id, $score, $name) {

        $sql = "INSERT INTO user_chicken_sandwich (user_id, chicken_id, score, name) VALUES (:user, :chicken, :score, :name)";
        $params = [':user' => $user_id, ':chicken' => $chicken_sandwich_id, ':score' => $score, ':name' => $name];
        $this->executeQuery($sql, $params);

        return $chicken_sandwich_id;
    }

    // this function's purpose is to execute the query and return results as objects of specified class
    private function executeQuery($sql, $params = [], $class = null) {

        try {

            $query = $this->db->prepare($sql);
            $query->execute($params);
            return $class ? $query->fetchAll(PDO::FETCH_CLASS, $class) : $query->fetchAll();

        } catch (Exception $ex) {

            echo "{$ex->getMessage()}<br/>\n";
        }
    }
}

?>
