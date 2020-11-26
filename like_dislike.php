<?php
ob_start();
if(!isset($_SESSION)) session_start();
   if(!isset($_SESSION["loggedin"])) 
   {
       header("Location: login.php");
       exit;
   }
    require_once("connection.php");
    $conn = connection_establish();
    $user = $_SESSION['user_name'];
    $newsID=$_POST["nid"];

    if(isset($_POST["like"])) {
        $check_likes = "SELECT * FROM likes WHERE username='$user' AND article_id=$newsID;";
        $result = $conn->query($check_likes);
        if ($result->num_rows <= 0)
        {
            $add_query = "INSERT INTO likes (article_id, username) VALUES ($newsID, '$user');";
            $retval = mysqli_query($conn, $add_query);
            mysqli_close($conn);
        }
        header("Location: main.php");
    }
    else{
        header("Location: main.php");
    }

    if(isset($_POST["dislike"]))
    {
        $delet_likes = "SELECT * FROM likes WHERE username='$user' AND article_id=$newsID;";
        $result = mysqli_query($conn,$delet_likes);
        $row = mysqli_fetch_array($result);
        $x=$row['likes_id'];
        $query= mysqli_query($conn,"DELETE FROM likes WHERE likes_id= $x");
        mysqli_close($conn);
        header("Location: main.php");
    }
    else{
        header("Location: main.php");
    }
    if(isset($_POST['delet_n']))
    {
        $query= mysqli_query($conn,"DELETE FROM news WHERE article_id= $newsID");
        $querry2 = mysqli_query($conn,"DELETE FROM likes WHERE article_id= $newsID");
        mysqli_close($conn);
        header("Location: main.php");
    }
    else{
        header("Location: main.php");
    }
?>