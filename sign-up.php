<?php

    require_once('restrict-access.php');

    require_once('page-titles.php');
    $page_title = MR_SIGNUP_PAGE;

    require_once('headings.php');
    $heading = MR_SIGNUP_HEADING;

            
    require_once('head.php'); 
    
                        
?>

<main>

    <?php require_once('heading.php'); ?>

    <form class="needs-validation" novalidate method="POST" id="sign-up-form"
        action="user-service.php">
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
                    Please provide a valid password.
                </div>
            </div>
        </div>
        <button class="btb btn-primary" type="submit">Sign Up</button>
    </form>
</main>

<script src="js/formValidation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="js/togglePassword.js"></script>
                
                            
       

  