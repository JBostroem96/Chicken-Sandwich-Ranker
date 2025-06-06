<?php

    require_once('DB.php');
    require_once('image-file-util.php');
    require_once('profile-image-file-util.php');
    require_once('display-user-info.php');

    //This class' purpose is to perform queries related to the user
    class UserManager {

        private $db;
        private $image;
        private $image_error;
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

            foreach ($user as $user_entry) {

                displayUserInfo($user_entry);
            }
        }

        //This function's purpose return the query for authentication
        public function authenticate($username) {

            $sql = "SELECT * FROM user WHERE username = :username";
            $results = $this->executeQuery($sql, [':username' => $username], null);

            return $results;
        }

        //This function's purpose is to log in
        public function logIn($username, $password) {

            $results = $this->authenticate($username);

            if (count($results) === 1) {

                foreach ($results as $row) {

                    if (password_verify($password, $row['password'])) {

                        $_SESSION['id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['access_privileges'] = $row['access_privileges'];
                        $_SESSION['image'] = $row['image'];

                        header("Location: index.php");

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

        //This function's purpose is to validate the profile image
        public function validateProfileImage() {

            $error = false;
            $profile_image = $_FILES['profile-image'];

            $this->image_error = validateProfileImageFile($profile_image);
            $this->image = addProfileImageFileReturnPathLocation($profile_image);

            if (!empty($this->image_error)) {

                
                echo "<p class='text-danger text-center'>{$this->image_error}</p>";
                $error = true;

            } if (empty($this->image)) {

                echo "<p class='text-danger text-center'>There was an error uploading this image</p>";
                $error = true;
            }

            return $error;

        }

        //This function's purpose is to sign the user up
        public function signUp($username, $password, $image) {
            
            $results = $this->authenticate($username);

            if (empty($results)) {

                $salted_hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user (username, password, image) VALUES (:username, :password, :image)";
                $this->executeQuery($sql, [':username' => $username, ':password' => $salted_hashed_password, ':image' => $image]);

                echo "<h4><p class='text-success'>Thank you for signing up <strong>$username</strong>! "
                    . "Your new account has been successfully created<br/>"
                    . "You're now ready to <a href='login.php'>log in</a></p></h4>";

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

        //This function's purpose is to update the user's image
        public function updateProfileImage($id) {

            if ($this->validateProfileImage()) {

                return;
            }

            $sql = "UPDATE user SET image = :image WHERE id = :id";

            $this->executeQuery($sql, [':id' => $id, ':image' => $this->image]);

            //escapes special characters
            $_SESSION['image'] = htmlspecialchars($this->image, ENT_QUOTES, 'UTF-8');
                
            echo "<p class='text-success text-center'>You successfully updated your user avatar!</p>";

            $this->readById($id);
        }
    }
?>