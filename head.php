<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=News+Cycle&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/chicken_style.css">
    <link rel="stylesheet" type="text/css" href="styles/rating.css">
    <link rel="stylesheet" type="text/css" href="styles/user.css">
    <title><?= $page_title ?></title>
</head>
<header>
    <nav class="navbar navbar-expand-md"
        data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Chicken Sandwich Ranker</a>
            <button class="navbar-toggler text-white" type="button"
                data-bs-toggle="collapse" 
                data-bs-target="#navbarContent"
                aria-controls="navbarContent"
                aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="chicken_search.php">Chicken Sandwich</a></li>
                        
                    <?php 
                        if (!empty($_SESSION['id'])) {

                            if ($_SESSION['access_privileges'] == 'admin') {

                                echo "<li class='nav-item'><a class='nav-link text-white' href='enter_chicken.php'>Enter Chicken Sandwich</a></li>";
                            }

                            echo "</ul><ul class='nav navbar-nav ms-auto'>";
                            echo "</ul><ul class='nav navbar-nav ms-auto'>";
                            echo "<li class='nav-item'><a class='nav-link text-white' id='user'href='user_service.php?userInfo={$_SESSION['username']}'>{$_SESSION['username']}</a></li>";
                            echo "<li class='nav-item'><a class='nav-link text-white' href='logout.php'>Log Out ({$_SESSION['username']})</a></li></ul>";
    
                        } else {

                            echo "<li class='nav-item'><a class='nav-link text-white' href='signup.php'>Sign Up</a>";
                            echo "<li class='nav-item'><a class='nav-link text-white' href='login.php'>Log In</a>";  
                        }
                    ?>
                                        
                </ul>
            </div>
        </div>
    </nav>
</header>
<body class="container bg-white">
    
