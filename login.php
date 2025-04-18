<?php

    require_once('restrict-access.php');

    require_once('page-titles.php');
    $page_title = MR_LOGIN_PAGE;

    
    require_once('headings.php');
    $heading = MR_LOGIN_HEADING;

    require_once('head.php');
    

?>
    
<main>
            
    <?php require_once('heading.php'); ?>

    <form class="needs-validation" novalidate method="POST" id="login-form"
            action="user-service.php">
        <div class="form-group row">
            <label for="username"
                class="col-sm-2 col-form-label-lg">Username</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"
                    id="username" name="usernameLogIn"
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
                    id="password" name="passwordLogIn"
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
            name="logIn">Log In
        </button>
        <br>
        <p>Don't have an account? <a href='sign-up.php'>Sign up here!</a> 
    </form>  
</main>
        
        <!-- javascript to validate the form -->
        <script src="js/formValidation.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- javascript to toggle the password -->
        <script src="js/togglePassword.js"></script>
        
        <?php require_once("footer.php"); ?>
    </body>  
</html>