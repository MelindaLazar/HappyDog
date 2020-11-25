<?php
ob_start();
if(!isset($_SESSION)) session_start();
if(!isset($_SESSION["loggedin"])) 
{
    header("Location: login.php");
    exit;
}
function user_table(){
    require_once("connection.php");
    $conn = connection_establish();
    $query = "SELECT * FROM kutya WHERE 1";
    if (isset($_POST['color'])){
        $query = $query." AND szin IN (";
        $color = $_POST['color'];
        $len = count($color);
        for ($i = 0; $i <= $len-1; $i++){
            if ($i < $len-1){
                $query = $query."'".$color[$i]."'".",";
            }
            else{
                $query = $query."'".$color[$i]."'";
            }
        };
        $query = $query.")";
    }
    if (isset($_POST['type'])){
        $query = $query." AND fajta IN (";
        $type = $_POST['type'];
        $len = count($type);
        for ($i = 0; $i <= $len-1; $i++){
            if ($i < $len-1){
                $query = $query."'".$type[$i]."'".",";
            }
            else{
                $query = $query."'".$type[$i]."'";
            }
        };
        $query = $query.")";
    }
    if (isset($_POST['gender'])){
        $gender = $_POST['gender'];
        $query = $query." AND nem = '$gender'";
    }
    if (isset($_POST['age'])){
        if ($_POST['age'] != "mindegy") {
            $age = $_POST['age'];
            $query = $query." AND kor = $age";
        }
    }
    //echo $query;
    echo "<form action='ownering.php' method='POST'> <table>";
    foreach($conn->query($query) as $row){
        $kutyaid = $row['id'];
        $nev = $row['nev'];
        $nem = $row['nem'];
        $fajta = $row['fajta'];
        $szin = $row['szin'];
        $kor = $row['kor'];
        $foglalo_user = $row['user_id'];
        if ($foglalo_user == $_SESSION['user_name']) {
            echo "<tr><td>$nev<td><td>$nem</td><td>$fajta</td><td>$szin</td><td>$kor</td><td><button type='submit' name='button' id='button' value='$kutyaid'>Foglalás törlése</button></td><tr>";
        }elseif (is_null($foglalo_user)) {
            echo "<tr><td>$nev<td><td>$nem</td><td>$fajta</td><td>$szin</td><td>$kor</td><td><button type='submit' name='button' id='button' value='$kutyaid'>Lefoglalom</button></td><tr>";
        }
        else{
            echo "<tr><td>$nev<td><td>$nem</td><td>$fajta</td><td>$szin</td><td>$kor</td><td><button type='submit' name='button' id='button' value='$kutyaid' disabled>Ezt a kutyát már lefoglalták!</button></td><tr>";
        }
        
    }
    echo "</table></form>";
}

function admin_foglalasok(){
    require_once("connection.php");
    $conn = connection_establish();
    $query = "SELECT * FROM kutya WHERE user_id is not null";
    //echo $query;
    echo "<h2>Aktív foglalások</h2><br><form action='ownering.php' method='POST'> <table>";
    foreach($conn->query($query) as $row){
        $kutyaid = $row['id'];
        $nev = $row['nev'];
        $nem = $row['nem'];
        $fajta = $row['fajta'];
        $szin = $row['szin'];
        $kor = $row['kor'];
        $foglalo_user = $row['user_id'];
        echo "<tr><td>$nev<td><td>$nem</td><td>$fajta</td><td>$szin</td><td>$kor</td><td>$foglalo_user</td><td><button type='submit' name='adminbutton' id='adminbutton' value='$kutyaid'>Foglalás törlése</button></td><tr>";
        
    }
    echo "</table></form>";
}

function admin_kutyak(){
    require_once("connection.php");
    $conn = connection_establish();
    $query = "SELECT * FROM kutya ";
    //echo $query;
    echo "<h2>Összes kutyák</h2><br><form action='ownering.php' method='POST'> <table>";
    foreach($conn->query($query) as $row){
        $kutyaid = $row['id'];
        $nev = $row['nev'];
        $nem = $row['nem'];
        $fajta = $row['fajta'];
        $szin = $row['szin'];
        $kor = $row['kor'];
        $foglalo_user = $row['user_id'];
        echo "<tr><td>$nev<td><td>$nem</td><td>$fajta</td><td>$szin</td><td>$kor</td><td>$foglalo_user</td><td><button type='submit' name='dogdelete' id='dogdelete' value='$kutyaid'>Kutya törlése</button></td><tr>";
        
    }
    echo "</table></form>";
}

function admin_kutyatad(){
    echo "<form action='admin_kutyaad.php'><input type='submit' value='Új kutya hozzáadása'> </form>";
}


?>