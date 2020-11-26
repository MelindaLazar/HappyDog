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
    echo "<form action='ownering.php' method='POST' class='dogsearch'> <table>
    <tr><th class='dst'>Kutya neve</th>
        <th class='dst'>Neme</th>
        <th class='dst'>Fajta</th>
        <th class='dst'>Szín</th>
        <th class='dst'>Életkor</th>
        <th>Foglalási státusz</th>
        </tr>";
    foreach($conn->query($query) as $row){
        $kutyaid = $row['id'];
        $nev = $row['nev'];
        $nem = $row['nem'];
        $fajta = $row['fajta'];
        $szin = $row['szin'];
        $kor = $row['kor'];
        $foglalo_user = $row['user_id'];
        if ($foglalo_user == $_SESSION['user_name']) {
            echo "<tr><td class='dst'>$nev</td><td class='dst'>$nem</td><td class='dst'>$fajta</td><td class='dst'>$szin</td><td class='dst'>$kor</td><td><button type='submit' name='button' id='button' value='$kutyaid' class=' btn btn_fogldel'>Foglalás törlése</button></td><tr>";
        }elseif (is_null($foglalo_user)) {
            echo "<tr><td class='dst'>$nev</td><td class='dst'>$nem</td><td class='dst'>$fajta</td><td class='dst'>$szin</td><td class='dst'>$kor</td><td><button type='submit' name='button' id='button' value='$kutyaid' class=' btn btn_reg'>Lefoglalom</button></td><tr>";
        }
        else{
            echo "<tr><td class='dst'>$nev</td><td class='dst'>$nem</td><td class='dst'>$fajta</td><td class='dst'>$szin</td><td class='dst'>$kor</td><td><button type='submit' name='button' id='button' value='$kutyaid' disabled class='btn'>Ezt a kutyát már lefoglalták!</button></td><tr>";
        }
        
    }
    echo "</table></form>";
}

function admin_foglalasok(){
    require_once("connection.php");
    $conn = connection_establish();
    $query = "SELECT * FROM kutya WHERE user_id is not null";
    //echo $query;
    echo "<h2>Aktív foglalások</h2><br><form action='ownering.php' method='POST' class='dogsearch'> <table>
    <tr><th class='dst'>Kutya neve</th>
        <th class='dst'>Neme</th>
        <th class='dst'>Fajta</th>
        <th class='dst'>Szín</th>
        <th class='dst'>Életkor</th>
        <th class='dst'>Fogló felhasználó</th>
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
        echo "<tr><td class='dst'>$nev</td><td class='dst'>$nem</td><td class='dst'>$fajta</td><td class='dst'>$szin</td><td class='dst'>$kor</td><td class='dst'>$foglalo_user</td><td><button type='submit' name='adminbutton' id='adminbutton' value='$kutyaid' class='btn btn_fogldel'>Foglalás törlése</button></td><tr>";
        
    }
    echo "</table></form>";
}

function admin_kutyak(){
    require_once("connection.php");
    $conn = connection_establish();
    $query = "SELECT * FROM kutya ";
    //echo $query;
    echo "<h2>Összes kutyák</h2><br><form action='ownering.php' method='POST' class='dogsearch'> <table>
    <tr><th class='dst'>Kutya neve</th>
        <th class='dst'>Neme</th>
        <th class='dst'>Fajta</th>
        <th class='dst'>Szín</th>
        <th class='dst'>Életkor</th>
        <th>Kutya kezelése</th>
        </tr>";
    foreach($conn->query($query) as $row){
        $kutyaid = $row['id'];
        $nev = $row['nev'];
        $nem = $row['nem'];
        $fajta = $row['fajta'];
        $szin = $row['szin'];
        $kor = $row['kor'];
        $foglalo_user = $row['user_id'];
        echo "<tr><td class='dst'>$nev</td><td class='dst'>$nem</td><td class='dst'>$fajta</td><td class='dst'>$szin</td><td class='dst'>$kor</td><td class='dst'>$foglalo_user</td><td><button type='submit' name='dogdelete' id='dogdelete' value='$kutyaid' class='btn btn_fogldel'>Kutya törlése</button></td><tr>";
        
    }
    echo "</table></form>";
}

function admin_kutyatad(){
    echo "<form action='admin_kutyaad.php'><input type='submit' value='Új kutya hozzáadása' class='btn btn_news btn_reg'> </form>";
}


?>