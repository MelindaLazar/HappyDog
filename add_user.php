<?php 
    ob_start();
    if(!isset($_SESSION["loggedin"])) 
    {
        header("Location: login.php");
        exit;
    }
    if ((!isset($_POST['username']) && !isset($_POST['passw']) && !isset($_POST['passw2']))){
        header("Location: register.php");
        die;
    }
    else if (!preg_match('/^[A-Za-z0-9]+$/', $_POST['username'])){
        header("Location: register.php?errormsg=Felhasználónév formátum nem megfelelő!");
        die;
    }
    else if (!preg_match('/^[A-Za-z0-9]+$/', $_POST['passw'])){
        header("Location: register.php?errormsg=Jelszó formátum nem megfelelő!");
        die;
    }
    else if ($_POST['passw'] != $_POST['passw2']){
        header("Location: register.php?errormsg=Két megadott jelszó nem egyezik!");
        die;
    }
    else{
        require_once("connection.php");
        $conn = connection_establish();
        $username = $conn->real_escape_string($_POST['username']);
        $passw = $conn->real_escape_string($_POST['passw']);
        $salt = random_bytes(16);
        $verification_code = base64_encode(random_bytes(6));
        $hash_input =  hash_pbkdf2('SHA1', $passw, $salt ,65536,16, true);
        $salted_hash = base64_encode($salt)."$".base64_encode($hash_input);
        $add_query = "INSERT INTO users (username, password) VALUES ('$username', '$salted_hash')";
        if($conn->query($add_query) === true){
            header("Location: login.php?errormsg=Felhasználó sikeresen létrehozva, most már be lehet jelentkezni");
            $conn->close();
            die();
        }
        else if ($conn->errno == 1062){
            header("Location: register.php?errormsg=Már létezik ilyen nevű felhasználó");
            $conn->close();
            die();
        }
    }

?>