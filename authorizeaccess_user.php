<?php

    session_start();

    if (!isset($_SESSION['id']) || !isset($_SESSION['access_privileges']))
    {
        header("Location: index.php");
        exit();
    }

    if ($_SESSION['access_privileges'] != 'admin' && $_SESSION['access_privileges'] != 'user') {
        header("Location: index.php");
        exit();
    }
?>
