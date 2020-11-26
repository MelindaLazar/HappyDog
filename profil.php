<?php
    ob_start();
    if(!isset($_SESSION)) session_start();
    require_once("connection.php");
    $conn = connection_establish();
    if(!isset($_SESSION["loggedin"])) 
    {
        header("Location: login.php");
        exit;
    }
    $user = $_SESSION['user_name'];
    if(isset($_POST['foszt']) && isset($_POST['megfosztott']))
    {
        $megfosztott = $_POST['megfosztott'];
        $sql="UPDATE users SET level = 0 WHERE username = '$megfosztott';";
        $retval = mysqli_query($conn, $sql);
        mysqli_close($conn);
    }
    if(isset($_POST['emel']) && isset($_POST['felemel']))
    {
        $megfosztott = $_POST['felemel'];
        $sql="UPDATE users SET level = 1 WHERE username = '$megfosztott';";
        $retval = mysqli_query($conn, $sql);
        mysqli_close($conn);
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
            <a href="main.php" > Kezdőlap</a>
            <a href="#" class="active"><?PHP if($_SESSION['level']!=1){echo "Profilom";}else{ echo "Felhasználók";}?></a>
            <a href="dogalert.php">DogAlert</a>
            <a href="logout.php">Kijelentkezés</a>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
        </div>
        <?php if ($_SESSION['level'] != 1) { ?>
            <div class="row p">
                <div class="col-12 col-t-12">
                    <h1>Adataim</h1>
                </div>
            </div>
            <div class="row p">
                <div class="col-12 col-t-12">
                    <h2>Általam lefoglalt kutyák</h2>
                    <?php 
                        require_once("connection.php");
                        $conn = connection_establish();
                        $query = "SELECT * FROM kutya WHERE user_id = '$user'";
                        //echo $query;
                        echo "<table class='dogsearch'>
                            <tr><th class='dst'>Kutya neve</th>
                            <th class='dst'>Neme</th>
                            <th class='dst'>Fajta</th>
                            <th class='dst'>Szín</th>
                            <th class='dst'>Életkor</th>
                            <th>Foglalás kezelése</th>
                            </tr>";
                        foreach($conn->query($query) as $row){
                            $kutyaid = $row['id'];
                            $nev = $row['nev'];
                            $nem = $row['nem'];
                            $fajta = $row['fajta'];
                            $szin = $row['szin'];
                            $kor = $row['kor'];
                            $foglalo_user = $row['user_id'];
                            echo "<tr><td class='dst'>$nev</td><td class='dst'>$nem</td><td class='dst'>$fajta</td><td class='dst'>$szin</td><td class='dst'>$kor</td><td><button type='submit' name='adminbutton' id='adminbutton' value='$kutyaid' class='btn btn_fogldel'>Foglalás törlése</button></td><tr>";
                            
                        }
                        echo "</table>";
                    ?>
                </div>
            </div>
        <?php }else{ ?>
            <div class="row p">
                <div class="col-12 col-t-12">
                    <h1>Tagok listája</h1>
                </div>
            </div>
            <div class="row p">
                <div class="col-12 col-t-12">
                    <?php
                        require_once("connection.php");
                        $conn = connection_establish();
                        $query = "SELECT * FROM users;";
                    ?>
                    <table class='dogsearch'>
                        <tr>
                            <td class='dst'> 
                                Azonosító
                            </td>
                            <td class='dst'>
                                Felhasználónév
                            </td>
                            <td class='dst'>
                                Felhasználói szint
                            </td>
                            <td class='dst'>
                                Műveletek
                            </td>
                        </tr>
                        <?php foreach($conn->query($query) as $row){
                            if($row['username']!=$_SESSION['user_name']){?>
                            <tr>
                                <td class='dst'> <?php echo $row["id"]; ?> </td>
                                <td class='dst'> <?php echo $row["username"]; ?> </td>
                                <td class='dst'> <?php if($row["level"] ==1) echo "<b>Admin</b>"; else echo "Felhasználó"; ?> </td>
                                <td class='dst'> <?php if($row["level"] ==1){ 
                                    echo "<form action='profil.php' method='POST'>".
                                    "<input type='hidden' value='".$row['username']."' name='megfosztott'>
                                    <input type='submit' value='Felhasználóvá tétel' name='foszt' class='btn btn_fogldel'></form>"; }
                                else { 
                                    echo "<form action='profil.php' method='POST'>".
                                    "<input type='hidden' value='".$row['username']."' name='felemel'>
                                    <input type='submit' value='Adminná tétel' name='emel' class='btn btn_reg'></form>"; } ?> </td>
                            </tr>
                        <?php        
                         } }
                            ?>
                    </table>
                </div>
            </div>
     <?php   } ?> 
    </body>
</html>