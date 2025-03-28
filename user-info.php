
            
<?php
    //This function's purpose is to display the user information
    function display($user) {
        
        echo "<div class='d-flex flex-column'>";

        if (!isset($_POST['password-to-change'])) {

            echo "<table id='user-info'"
                . "<tr><th>Username: </th><td>" . $user->getUsername()  
                . "</td></tr><tr><th>User Type: </th><td>" . $user->getAccessPrivileges() 
                . "</td></tr><tr><th>Date Created: </th><td>" . $user->getDateCreated()
                . "</td></tr><tr><th>Profile Image: </th><td><img src='" . htmlspecialchars($user->getImage(), ENT_QUOTES, 'UTF-8') . "' id='user-profile-image' alt='user profile image'>"
                . "</td>
                </table>
            <form enctype='multipart/form-data' class='needs-validation' novalidate method='POST'
                action='user-service.php'>
                                
                <div class='form-group'>
                    <label for='image'>Image</label>
                    <input type='file' id='edit-image' name='image' class='form-control'
                    placeholder='image' required>
                    <div class='invalid feedback'>
                        <p>Please provide a valid image<p>
                    </div>
                </div>
                <button type='submit' name='edit-image'>UPDATE</button>
            </form>";

                    
    echo "<div class='d-flex'>" .

        "<form action='user-chicken-sandwich-service.php' method='GET' class='mx-1'>
        <button class='button' type='submit' id='user-scores'
        name='user-scores'>YOUR RATINGS</button></form>
                        
        <form action='user-service.php' method='POST'>
        <button class='button' type='submit'
        name='delete-user'>DELETE</button>
        <button class='button' type='submit'
        name='password-to-change'>EDIT PASSWORD</button>";

        } else {

            require_once('user-password-form.php');
            ?>
                
    <?php

                }
               
            }
                
    ?>

        <?php require_once("footer.php"); ?>
        
    </body>
</html>