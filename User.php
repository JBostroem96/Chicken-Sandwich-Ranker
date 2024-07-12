<?php 

require_once('pagetitles.php');
$page_title = MR_USER_PAGE;

require_once('headings.php');
$heading = MR_USER_HEADING;
?>

<!DOCTYPE html>
<html>
<?php require_once('head.php'); ?>
    <main class='mt-2'>

        <?php require_once('heading.php');               
       
        class User {

            private $id;
            private $username;
            private $password;
            private $access_privileges;
            private $date_created;
            
            /**
             * Get the value of id
             */ 
            public function getId()
            {
                        return $this->id;
            }

            /**
             * Set the value of id
             *
             * @return  self
             */ 
            public function setId($id)
            {
                        $this->id = $id;

                        return $this;
            }

            /**
             * Get the value of username
             */ 
            public function getUsername()
            {
                        return $this->username;
            }

            /**
             * Set the value of username
             *
             * @return  self
             */ 
            public function setUsername($username)
            {
                        $this->username = $username;

                        return $this;
            }

            /**
             * Get the value of password
             */ 
            public function getPassword()
            {
                        return $this->password;
            }

            /**
             * Set the value of password
             *
             * @return  self
             */ 
            public function setPassword($password)
            {
                        $this->password = $password;

                        return $this;
            }

            /**
             * Get the value of access_privileges
             */ 
            public function getAccess_privileges()
            {
                        return $this->access_privileges;
            }

            /**
             * Set the value of access_privileges
             *
             * @return  self
             */ 
            public function setAccess_privileges($access_privileges)
            {
                        $this->access_privileges = $access_privileges;

                        return $this;
            }

            /**
             * Get the value of date_created
             */ 
            public function getDate_created()
            {
                        return $this->date_created;
            }

            /**
             * Set the value of date_created
             *
             * @return  self
             */ 
            public function setDate_created($date_created)
            {
                        $this->date_created = $date_created;

                        return $this;
            }

            //This function's purpose is to display the user information
            public function display($user) {
                
                echo "<div class='d-flex flex-column'>";

                if (!isset($_POST['edit_user'])) {

                    echo "<table id='userInfo'" 
                        . "<tr><th>Username: </th><td>" . $user->getUsername()  
                        . "</td></tr><tr><th>User Type: </th><td>" . $user->getAccess_privileges() 
                        . "</td></tr><th>Date Created: <td>" . $user->getDate_created()
                        . "</td></tr></table>";
                    
                    echo "<div class='d-flex'>" .

                        "<form action='user_chicken_sandwich_service.php' method='GET' class='mx-1'>
                        <button class='button' type='submit' id='user_scores'
                        name='user_scores'>YOUR RATINGS</button></form>
                        
                        <form action='user_service.php' method='POST'>
                        <button class='button' type='submit' id='user_scores'
                        name='delete_user'>DELETE</button>
                        <button class='button' type='submit' id='user_scores'
                        name='edit_user'>EDIT PASSWORD</button></form></div></div>";

                } else {
                        ?>

                    <form action='user_service.php' method='POST'>
                        <label for="currentPassword"
                                class="col-sm-2 col-form-label-lg">Current Password:</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control"
                                        id="currentPassword" name="currentPassword"
                                        placeholder="Enter a password" required>
                                <div class="invalid-feedback">
                                    Please provide a valid password
                                </div>
                            </div>
                            <label for="password"
                                class="col-sm-2 col-form-label-lg">New Password:</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control"
                                        id="password" name="newPassword"
                                        placeholder="Enter a password" required>
                                <div class="invalid-feedback">
                                    Please provide a valid password
                                </div>
                            </div>
                            <label for="repeatPassword"
                                class="col-sm-2 col-form-label-lg">Enter Password Again:</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control"
                                        id="repeatPassword" name="repeatPassword"
                                        placeholder="Enter a password" required>
                                <div class="invalid-feedback">
                                    Please provide a valid password
                                </div>
                            </div>
                            <button type="submit"
                                name="edit_password">EDIT
                            </button>
                    </form>
                    <?php

                }
               
            }
        }
                
                    ?>

        <?php require_once("footer.php"); ?>
    </body>
</html>

    
    


    

