<?php
    ob_start();
    if(!isset($_SESSION)) session_start();
    if(isset($_SESSION["loggedin"]))
    {
        session_destroy();
        $_SESSION=array();
        header("Location: login.php");
    }
?>