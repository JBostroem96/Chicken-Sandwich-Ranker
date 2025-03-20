<?php

    require_once('pagetitles.php');
    $page_title = MR_SIGNUP_PAGE;

    require_once('headings.php');
    $heading = MR_SIGNUP_HEADING;

    require_once('UserManager.php');
?>

<!DOCTYPE html>
<html>
    <?php require_once('head.php'); ?>
    
        <main class='mt-4'>

            <?php require_once('heading.php');

                $show_sign_up_form = true;

                if (isset($_POST['signUp'])) {
                    
                    $username = $_POST['user_name'];
                    $password = $_POST['password'];
                    $image = 'images/user.png';

                    $user_manager = new UserManager();

                    $user_manager->signUp($username, $password, $show_sign_up_form, $image);                 
                }
                
                if ($show_sign_up_form):
            ?>
                    <form class="needs-validation" novalidate method="POST" id="signup_form"
                        action="<?= $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group row">
                            <label for="user_name"
                                class="col-sm-2 col-form-label-lg">User Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"
                                    id="user_name" name="user_name"
                                    placeholder="Enter a user name" required>
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
                                        id="show_password-check"
                                        onclick="togglePassword()">
                                    <label class="form-check-label"
                                        for="show_password_check">Show Password</label>
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid password.
                                </div>
                            </div>
                        </div>
                        <button class="btb btn-primary" type="submit"
                                name="signUp">Sign Up
                        </button>
                    </form>
                    <?php
                        endif;
                    ?>
        </main>
            
        <script src="js/formValidation.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="js/togglePassword.js"></script>
        
        <?php require_once("footer.php"); ?>
    </body>          
</html>