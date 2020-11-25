<?php 
ob_start();
if(!isset($_SESSION)) session_start();
    if(!isset($_SESSION["loggedin"])) 
    {
        header("Location: login.php");
        exit;
    }
if (!($_SESSION['level'] == 1)) {
    header("Location: main.php");
}
else{
require_once("connection.php");
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NetBeans">
    <meta name="description" content="HappyDog állatmenhely weboldala">
    <title>HappyDog - Kezdőlap</title>
    <link rel="stylesheet"  href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;400&display=swap" rel="stylesheet">   
    <link href="images/favicon.png" rel="icon" type="image/x-icon">
</head>
<body>
    <div class="topnav" id="myTopnav">
        <a href="#" class="active"> Kezdőlap</a>
        <a href="profilom.php">Profilom</a>
        <a href="dogalert.php">DogAlert</a>
        <a href="logout.php">Kijelentkezés</a>
        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
    <div class="row p">
        <h1>Új kutya hozzáadása</h1>
    </div>
    <div class="row p">
        <form action="admin_kutyaad.php" method="POST">
            Név: <input type="text" name="nev"> <br>
            Szín: <input type="text" name="szin"> <br>
            Fajta: <input type="text" name="fajta"> <br>
            Nem: <input type="radio" name="nem" value="Fiú" id="fiu"> <label for="fiu">Fiú </label> <input type="radio" name="nem" value="Lány" id="lany"> <label for="lany">Lány </label>  <br>
            Kor: <input type="number" name="kor"> <br>
            <input type="submit" name="add" value="Kutya regisztrálása">
        </form>
        <?php 
        if (isset($_POST['add'])) {
            $conn = connection_establish();
            $nev = $_POST['nev'];
            $nem = $_POST['nem'];
            $fajta = $_POST['fajta'];
            $szin = $_POST['szin'];
            $kor = $_POST['kor'];
            $query = "INSERT INTO kutya (nev, nem, fajta, szin, kor) VALUES ('$nev', '$nem', '$fajta', '$szin', $kor)";
            $conn->query($query);
            echo "<h2>Kutya sikeresen hozzáadva!</h2>";
        }
        ?>
    </div>
    <script>
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
            }
    </script>    
</body>
</html>





<?php
}
?>