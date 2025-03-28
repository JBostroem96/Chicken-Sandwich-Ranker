    <?php
        echo "<table id='user-info'"
                . "<tr><th>Username: </th><td>" . $user->getUsername()  
                . "</td></tr><tr><th>User Type: </th><td>" . $user->getAccessPrivileges() 
                . "</td></tr><tr><th>Date Created: </th><td>" . $user->getDateCreated()
                . "</td></tr><tr><th>Profile Image: </th><td><img src='" . htmlspecialchars($user->getImage(), ENT_QUOTES, 'UTF-8') . "' id='user-profile-image' alt='user profile image'>"
                . "</td>
                </table>";

        require_once('user-account-buttons.php');
    ?>
