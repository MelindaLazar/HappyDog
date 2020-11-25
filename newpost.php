<?php
    ob_start();
    if(!isset($_SESSION)) session_start();
    if(!isset($_SESSION["loggedin"])) 
    {
        header("Location: login.php");
        exit;
    }
    if(!isset($_POST['feladas'])||strlen($_POST['newp'])<=0)
    {
            header("Location: main.php?errormsg=A mező kitöltése kötelező!");
            die;
    }
    else
    {
        $user = $_SESSION['user_name'];
        $post_n =mysqli_real_escape_string($conn,$_POST['newp']);
        require_once("connection.php");
        $conn = connection_establish();
        $add_news = "INSERT INTO news (author, article) VALUES ('$user','$post_n');";
        $retval = mysqli_query($conn, $add_news);
        mysqli_close($conn);
        header("Location: main.php");
    }
?>