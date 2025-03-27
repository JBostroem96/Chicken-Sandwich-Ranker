<?php 

    require_once('page-titles.php');
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
            private $image;
            
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
            public function getAccessPrivileges()
            {
                        return $this->access_privileges;
            }

            /**
             * Set the value of access_privileges
             *
             * @return  self
             */ 
            public function setAccessPrivileges($access_privileges)
            {
                        $this->access_privileges = $access_privileges;

                        return $this;
            }

            /**
             * Get the value of date_created
             */ 
            public function getDateCreated()
            {
                        return $this->date_created;
            }

            /**
             * Set the value of date_created
             *
             * @return  self
             */ 
            public function setDateCreated($date_created)
            {
                        $this->date_created = $date_created;

                        return $this;
            }

            /**
             * Get the value of image
             */ 
            public function getImage()
            {
                        return $this->image;
            }

            /**
             * Set the value of image
             *
             * @return  self
             */ 
            public function setImage($image)
            {
                        $this->image = $image;

                        return $this;
            }

            //This function's purpose is to display the user information
            public function display($user) {
                
                echo "<div class='d-flex flex-column'>";

                if (!isset($_POST['edit-user'])) {

                    echo "<table id='user-info'"
                            . "<tr><th>Username: </th><td>" . $user->getUsername()  
                            . "</td></tr><tr><th>User Type: </th><td>" . $user->getAccessPrivileges() 
                            . "</td></tr><tr><th>Date Created: </th><td>" . $user->getDateCreated()
                            . "</td></tr><tr><th>Profile Image: </th><td><img src='" . $user->getImage() . "' id='user-profile-image'"
                            . "</td>
                        
                                <form enctype='multipart/form-data'
                                class='needs-validation' novalidate method='POST'
                                action='user-service.php'>
                                
                                    <div class='form-group'>
                                        <label for='image'>Image</label>
                                        <input type='file' id='image' name='image' class='form-control'
                                            
                                        placeholder='image' required>
                                        <div class='invalid feedback'>
                                            <p>Please provide a valid image<p>
                                        </div>
                                    </div>
                                </form> 
                            </tr>
                        </table>";

                    
                    echo "<div class='d-flex'>" .

                        "<form action='user-chicken-sandwich-service.php' method='GET' class='mx-1'>
                        <button class='button' type='submit' id='user-scores'
                        name='user-scores'>YOUR RATINGS</button></form>
                        
                        <form action='user-service.php' method='POST'>
                        <button class='button' type='submit' id='user-scores'
                        name='delete-user'>DELETE</button>
                        <button class='button' type='submit' id='user-scores'
                        name='edit-user'>EDIT PASSWORD</button>";

                } else {
                        ?>

                    <form action='user-service.php' method='POST'>
                        <label for="current-password"
                                class="col-sm-2 col-form-label-lg">Current Password:</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control"
                                        id="current-password" name="current-password"
                                        placeholder="Enter a password" required>
                                <div class="invalid-feedback">
                                    Please provide a valid password
                                </div>
                            </div>
                            <label for="password"
                                class="col-sm-2 col-form-label-lg">New Password:</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control"
                                        id="password" name="new-password"
                                        placeholder="Enter a password" required>
                                <div class="invalid-feedback">
                                    Please provide a valid password
                                </div>
                            </div>
                            <label for="repeated-password"
                                class="col-sm-2 col-form-label-lg">Enter Password Again:</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control"
                                        id="repeated-password" name="repeated-password"
                                        placeholder="Enter a password" required>
                                <div class="invalid-feedback">
                                    Please provide a valid password
                                </div>
                            </div>
                            <button type="submit"
                                name="edit-password">EDIT
                            </button>
                    </form>
                </main>
                
                    <?php

                }
               
            }
        }
                
                    ?>

        <?php require_once("footer.php"); ?>
        
    </body>
</html>

    
    


    

