<?php
    ob_start();
    if(!isset($_SESSION)) session_start();
    require_once("query_tables.php");
    if(!isset($_SESSION["loggedin"])) 
    {
        header("Location: login.php");
        exit;
    }
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
        <a href="main.php"> Kezdőlap</a>
        <a href="profilom.php">Profilom</a>
        <a href="dogalert.php" class="active">DogAlert</a>
        <a href="logout.php">Kijelentkezés</a>
        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
    <div class="row p">
        <h1>Üdvözöllek! <?php echo $_SESSION['user_name']?></h1>
    </div>
    <div class="row p">
        <?php if ($_SESSION['level'] == 0) {?>
        <form action = "dogalert.php" method = 'POST'>
            <?php require_once("connection.php");
            $conn = connection_establish();
            $szinek = array();
            $query = "SELECT DISTINCT szin FROM kutya"; 
            $resultasd = $conn->query($query);
            foreach ($resultasd as $key => $value) {
                array_push($szinek, $value['szin']);
            }
            $fajtak = array();
            $query = "SELECT DISTINCT fajta FROM kutya"; 
            $resultasd = $conn->query($query);
            foreach ($resultasd as $key => $value) {
                array_push($fajtak, $value['fajta']);
            }
            ?>
            Szín: 
            <?php 
            foreach ($szinek as $key => $szin) {
                echo "<input type = 'checkbox' name = 'color[]' value = '$szin'> $szin ";
            }
            echo "<br>Fajta: ";
            foreach ($fajtak as $key => $fajta) {
                echo "<input type = 'checkbox' name = 'type[]' value = '$fajta'> $fajta ";
            }
            echo "<br>";
            ?>
            
            
            <!--<input type = "checkbox" name = "color[]" value = "'Fekete'">Fekete <input type = "checkbox" name = "color[]" value = "'Kék'">Kék<br> -->
            <!-- Fajta: <select name = "type[]" multiple>
                        <option value = "'Labrador'">Labrador</option>
                        <option value = "'Német Juhász'">Német Juhász</option>
                   </select><br> -->
            Nem: <input type = "radio" name = "gender" value = "Fiú"> Fiú <input type = "radio" name = "gender" value = "Lány"> Lány <br>
            Kor: <select name = "age"><?php
                echo "<option value = 'mindegy'>Mindegy</option>";
                for($i = 1; $i<=20; $i++){
                    echo "<option value = $i>$i</option>";
                }
            ?></select>
            <button type = "submit" name = "search">Keresés</button>
        </form>
        <?php
            if (isset($_POST['search'])){
                echo "<br><br>";
                user_table();
            }
        ?>
        <?php }?>
        <?php if ($_SESSION['level'] == 1) {?>
            <h1>Admin felület</h1>
            <?php admin_foglalasok(); ?>
            <br><br><br>
            <?php admin_kutyak(); ?>
            <br><br>
            <?php admin_kutyatad(); ?>
        <?php }?>
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

