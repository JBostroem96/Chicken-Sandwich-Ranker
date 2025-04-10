<?php

    session_start();
    
    require_once('page-titles.php');
    $page_title = MR_LOGIN_PAGE;

    require_once('headings.php');
    $heading = MR_LOGIN_HEADING;

    require_once('UserManager.php');
?>

<!DOCTYPE html>
<html>

    <?php require_once('head.php'); ?>
    
        <main class='mt-4'>

            <?php 

                //if the user is not logged in, show the heading
                if (empty($_SESSION['id'])) {

                    require_once('heading.php');
                }
                
                //if the user logs in, authenticate them
                if (empty($_SESSION['id']) && isset($_POST['login'])) {

                    $username = $_POST['username'];
                    $password = $_POST['password'];
        
                    $user_manager = new UserManager();

                    if ($user_manager->login($username, $password) == true) {

                        header("Location: index.php");
                    }
                }
                
                //if the user is not logged in, display the form
                if (empty($_SESSION['id'])):
            ?>
                    <form class="needs-validation" novalidate method="POST" id="login-form"
                        action="<?= $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group row">
                            <label for="username"
                                class="col-sm-2 col-form-label-lg">Username</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"
                                    id="username" name="username"
                                    placeholder="Enter a username" required>
                                <div class="invalid-feedback">
                                    Please provide a valid user name
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password"
                                class="col-sm-2 col-form-label-lg">Password</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control"
                                        id="password" name="password"
                                        placeholder="Enter a password" required>
                                <div class="form-group form-check">
                                    <input type="checkbox"
                                        class="form-check-input"
                                        id="show-password-check"
                                        onclick="togglePassword()">
                                    <label class="form-check-label"
                                        for="show-password-check">Show Password</label>
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid password
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            name="login">Log In
                        </button>
                        <br>
                        <p>Don't have an account? <a href='sign-up.php'>Sign up here!</a> 
                    </form>

                    <?php

                        //if the user is logged in, display their username
                        elseif (isset($_SESSION['id'])):
                            echo "<h1 class='text-center'>{$_SESSION['username']}!</h1>";
                        endif;
                    ?>
                        
        </main>
        
        <!-- javascript to validate the form -->
        <script src="js/formValidation.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- javascript to toggle the password -->
        <script src="js/togglePassword.js"></script>
        
        <?php require_once("footer.php"); ?>
    </body>  
</html>