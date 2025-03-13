<?php

require_once('DB.php');

//This class' purpose is to perform queries related to the user
class UserManager {

    private $db;
    private const CLASS_USER = 'User';

	//This function's purpose is to be the constructor, which connects to the DB
    public function __construct() {

        $this->db = (new DB())->connect();
    }

    //This function's purpose is to execute the different queries
    private function executeQuery($sql, $params = [], $class = null) {

        try {
            
            $query = $this->db->prepare($sql);
            $query->execute($params);
            return $class ? $query->fetchAll(PDO::FETCH_CLASS, $class) : $query->fetchAll();

        } catch (Exception $ex) {

            echo "{$ex->getMessage()}<br/>\n";
        }
    }

    //This function's purpose is to read all entries
    public function readAll() {

        $sql = "SELECT * FROM user";
        return $this->executeQuery($sql, [], self::CLASS_USER);
    }

    //This function's purpose is to read the entry by id
    public function readById($id) {

        $sql = "SELECT * FROM user WHERE id = :id";
        $results = $this->executeQuery($sql, [':id' => $id], self::CLASS_USER);
        $this->displayUser($results);
        
    }

    //This function's purpose is to display the user
    public function displayUser($user) {

        $userDisplay = new User();

        foreach ($user as $userEntry) {

            $userDisplay->display($userEntry);
        }
    }

    //This function's purpose return the query for authentication
    public function authenticate($username) {

        $sql = "SELECT * FROM user WHERE username = :username";
        $results = $this->executeQuery($sql, [':username' => $username], null);

        return $results;
    }

    //This function's purpose is to log in
    public function login($username, $password) {

        $results = $this->authenticate($username);

        if (count($results) === 1) {

            foreach ($results as $row) {

                if (password_verify($password, $row['password'])) {

                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['access_privileges'] = $row['access_privileges'];

                    return true;

                } else {

                    echo "<h3><p class='text-danger'>Incorrect password</p></h3></hr>";
                }
            }

        } elseif (empty($results)) {

            echo "<h3><p class='text-danger'>That user does not exist</p></h3></hr>";

        } else {

            echo "<h3><p class='text-danger'>Something went wrong!</p></h3></hr>";
        }
    }

    //This function's purpose is to sign the user up
    public function signUp($username, $password, $show_sign_up_form) {

        $results = $this->authenticate($username);

        if (empty($results)) {

            $salted_hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
            $this->executeQuery($sql, [':username' => $username, ':password' => $salted_hashed_password]);

            echo "<h4><p class='text-success'>Thank you for signing up <strong>$username</strong>! "
                . "Your new account has been successfully created<br/>"
                . "You're now ready to <a href='index.php'>log in</a></p></h4>";

            $show_sign_up_form = false;

        } else {

            echo "<h4><p class='text-danger'>An account already exists for this username: "
                . "<span class='font-weight-bold'>($username)</span>. "
                . "Please use a different user name.</p></h4></hr>";
        }
    }

    //This function's purpose is to delete the user
    public function delete($id) {

        $sql = "DELETE FROM user WHERE id = :id";
        $this->executeQuery($sql, [':id' => $id]);
    }

    //This function's purpose is to update the password
    public function updatePassword($new_password, $id) {

        $salted_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = :password WHERE id = :id";
        $this->executeQuery($sql, [':id' => $id, ':password' => $salted_hashed_password]);
    }
}

?>
