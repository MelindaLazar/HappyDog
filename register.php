<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HappyDog - Regisztráció</title>
    <link rel="stylesheet"  href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;400&display=swap" rel="stylesheet">   
    <link href="images/favicon.png" rel="icon" type="image/x-icon">
</head>
<body>
    <div class="row loginpage">
        <div class="col-6 col-t-12">
            <article>  
                <h1>Regisztráció</h1>
                <p>Gyors, egyszerű és kutyául megéri!</p>
            </article>
        </div>
        <div class="col-6 col-t-12">
            <form action = "add_user.php" method = "POST">
                <?php
                    if (isset($_GET['errormsg'])){
                        $errormsg = $_GET['errormsg'];
                        echo "<p><label class='errorbox'>$errormsg</label></p>";
                    }
                ?>
                <div class="input_icons">
                    <i class="fa fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Felhasználónév" required="required" class="inputLabel" autocomplete="off"/>
                </div>
                <div class="input_icons">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="passw" id="passw" placeholder="Jelszó" required="required" class="inputLabel"/>
                </div>
                <div class="input_icons">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="passw2" id="passw" placeholder="Jelszó mégegyszer" required="required" class="inputLabel"/>
                </div>
                <button type="submit" name="register" class="btn btn_reg button "><span>Regisztrálok</span></button>
                <hr>
                <button type="button" name="back" id="back" onclick="location.href='login.php'" class="btn button"><span>Vissza a belépéshez</span></button>   
            </form>
        </div>
    </div>
    
</body>
</html>