<?php 
    ob_start();
    if (!isset($_POST['username']) && isset($_POST['passw'])){
        header("Location: login.php");
        die;
    }
    else if (!preg_match('/^[A-Za-z0-9]+$/', $_POST['username'])){
        header("Location: login.php?errormsg=A felhasználónév formátuma nem megfelelő!");
        die;
    }
    else if (!preg_match('/^[A-Za-z0-9]+$/', $_POST['passw'])){
        header("Location: login.php?errormsg=A jelszó formátuma nem megfelelő!");
        die;
    }
    else{
        require_once("connection.php");
        $conn = connection_establish();
        $user = $conn->real_escape_string($_POST['username']);
        $passw = $_POST['passw'];
        $check_login = "SELECT * FROM users WHERE username='$user'";
        $result = $conn->query($check_login);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $stored = explode("$", $row["password"]);
            $hash_input =  hash_pbkdf2('SHA1', $passw, base64_decode($stored[0]),65536,16, true);
            $is_checked = base64_encode($hash_input) == $stored[1];
            switch ($is_checked){
                case 1:
                    session_start();
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['username'];
                    $_SESSION['loggedin']=true;
                    $_SESSION['level'] = $row['level'];
                    header("Location: main.php");
                    exit;
                case 0:
                    header("Location: login.php?errormsg=Nem megfelelő jelszó a beírt felhasználóhoz!");
                    exit;
            }
        }
        else{
            header("Location: login.php?errormsg=Nincs ilyen nevű regisztrált felhasználó");
            die;
        }
    }





?>