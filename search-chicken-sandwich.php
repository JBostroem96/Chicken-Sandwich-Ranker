<?php

    session_start();
    require_once('page-titles.php');
    $page_title = MR_SEARCH_PAGE;

    require_once('headings.php');
    $heading = MR_SEARCH_HEADING;

    require_once('head.php'); ?>
    
        <main class='mt-4'>

            <?php require_once('heading.php'); ?>

                    <form class="needs-validation" novalidate method="GET" id="search-form"
                        action="chicken-sandwich-service.php">
                        <div class="text-white p-3">
                            <label class="mb-2 text-muted fw-bold" for="search-term">Search</label>
                            <input  class="form-control" type="search" name="search-term" id="search-term">
                            <div class="form-group">
                                <label class="fw-bold" for="name">Name</label>
                                <input class="form-check-input" type="radio" name="search-type" id="name" value="name" checked>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="score">Score</label>
                                <input class="form-check-input" type="radio" name="search-type" id="score" value="score">
                            </div>
                            <button type="submit"
                                name="search">Search
                            </button>
                            <button type="submit"
                                name="view-all">Search All
                            </button>
                            <br>
                            
                    </form>
                   
        </main>
        
        <?php require_once("footer.php"); ?>        
    






