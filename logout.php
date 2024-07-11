<?php

session_start();

if (isset($_SESSION['id'])) {
    $_SESSION = array();
    session_destroy();

}

$home_url = dirname($_SERVER['PHP_SELF']);
header('Location: ' . $home_url);
exit;

?>