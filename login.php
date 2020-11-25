<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NetBeans">
    <meta name="description" content="HappyDog állatmenhely weboldala">
    <title>HappyDog - Lépj be, vagy regisztrálj</title>
    <link rel="stylesheet"  href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;400&display=swap" rel="stylesheet">   
    <link href="images/favicon.png" rel="icon" type="image/x-icon">
</head>
<body>
    <div class="row">
        <header></header>
    </div>
    <div class="row" hidden="hidden">
        <nav>
            <ul>
                <li class="col-4 col-t-4"> <a href="#" class="active"> Kezdőlap</a></li>
                <li class="col-4 col-t-4"> <a href="profilom.php">Profilom</a></li>
                <li class="col-4 col-t-4"> <a href="dogalert.php">DogAlert</a></li>
            </ul>
        </nav>
    </div>
    <div class="row loginpage">
        <div class="col-6 col-t-12">
            <article>  
                <h1>HappyDog</h1>
                <p>A HappyDog közösségben megtalálod a helyed, ha csak egy kis nyugalomra vagy akár egy vidámságban, kutyaságban gazdag hétvégére vágysz.</p>
            </article>  
        </div>
        <div class="col-6 col-t-12">
            <form action="check.php" method="POST">
                <?php 
                    if (isset($_GET['errormsg'])){
                        $errormsg = $_GET['errormsg'];
                        echo "<p><label  class='errorbox'>$errormsg</label></p>";
                    };
                ?>
                <div class="input_icons">
                    <i class="fa fa-user"></i><input type="text" id="username" name="username" placeholder="Felhasználónév" required="required" class="inputLabel" autocomplete="off"/>
                </div>
                <div class="input_icons">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="passw" id="passw" placeholder="Jelszó" required="required" class="inputLabel"/>
                </div>
    
                <button type="submit" name="login" class="btn button"><span>Belépek</span></button>
                <hr>
                <button type="button" name="register" onclick="location.href='register.php'" class="btn btn_reg button"><span>Új fiók létrehozása</span></button>   
            </form>
        </div>
    </div>
</body>
</html>