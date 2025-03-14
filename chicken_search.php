<?php

    session_start();
    require_once('pagetitles.php');
    $page_title = MR_SEARCH_PAGE;

    require_once('headings.php');
    $heading = MR_SEARCH_HEADING;

    require_once('UserManager.php');
?>

<!DOCTYPE html>
<html>
    <?php require_once('head.php'); ?>
    
        <main class='mt-4'>
            <?php require_once('heading.php'); 
                

                    if (empty($_SESSION['id']) && isset($_POST['login'])) {

                        $username = $_POST['user_name'];
                        $password = $_POST['password'];

                        $user_manager = new UserManager();

                        $user_manager->login($username, $password);

                    } else {

                        "<h3><p class='text-danger'>you must enter a username and password</p></h3></hr>";
                    }
                    
                    
                ?>
                    <form class="needs-validation" novalidate method="GET" id="search_form"
                        action="chicken_sandwich_service.php">
                        <div class="text-white p-3">
                            <label class="mb-2 text-muted fw-bold" for="searchTerm">Search</label>
                            <input  class="form-control" type="search" name="searchTerm" id="searchTerm">
                            <div class="form-group">
                                <label class="fw-bold" for="name">Name</label>
                                <input class="form-check-input" type="radio" name="searchType" id="name" value="name" checked>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="score">Score</label>
                                <input class="form-check-input" type="radio" name="searchType" id="score" value="score">
                            </div>
                            <button type="submit"
                                name="search">Search
                            </button>
                            <button type="submit"
                                name="viewAll">Search All
                            </button>
                            <br>
                            <?php if(!isset($_SESSION['id'])) { ?>

                                <p>Don't have an account? <a href='signup.php'>Sign up here!</a> 
                                
                                <?php
                            }
                                ?>
                    </form>
                   
        </main>
        
        <?php require_once("footer.php"); ?>        
    </body>   
</html>






