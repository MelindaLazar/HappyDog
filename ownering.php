<?php
    ob_start();
    if(!isset($_SESSION)) session_start();
    if(!isset($_SESSION["loggedin"])) 
    {
        header("Location: login.php");
        exit;
    }
    if(!(isset($_POST['button']) or isset($_POST['adminbutton']) or isset($_POST['dogdelete']))){
        header("Location: dogalert.php");
    }
    else{
    if(!isset($_SESSION)) session_start();
    require_once("connection.php");
    $conn = connection_establish();
    if (isset($_POST['button'])) {
        $kutyaid = $_POST['button'];
        $query = "SELECT * FROM kutya WHERE id = $kutyaid";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $name=$_SESSION['user_name'];
        if ($row['user_id'] == $_SESSION['user_name']) {
            $query2 = "UPDATE kutya SET user_id = null WHERE id = $kutyaid";
        }else{
            $query2 = "UPDATE kutya SET user_id = '$name' WHERE id = $kutyaid";
        }
        $conn->query($query2);
        header("Location: dogalert.php");
        }
        if (isset($_POST['adminbutton'])) {
            $kutyaid = $_POST['adminbutton'];
            $query2 = "UPDATE kutya SET user_id = null WHERE id = $kutyaid";
            $conn->query($query2);
            header("Location: dogalert.php");
        }
        if (isset($_POST['dogdelete'])) {
            $kutyaid = $_POST['dogdelete'];
            $query2 = "DELETE FROM kutya WHERE id = $kutyaid";
            $conn->query($query2);
            header("Location: dogalert.php");
        }
    }


?>