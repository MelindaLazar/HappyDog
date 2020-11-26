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
        <a href="profil.php"><?PHP if($_SESSION['level']!=1){echo "Profilom";}else{ echo "Felhasználók";}?></a>
        <a href="dogalert.php">DogAlert</a>
        <a href="logout.php">Kijelentkezés</a>
        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
    <div class="row p">
        <h1>Üdvözöllek! <?php echo $_SESSION['user_name']?></h1>
        <?php
           require_once("connection.php");
           $conn = connection_establish();
        ?>
        <h2>Frissítések</h2>
        <?php
            $sql = "SELECT * FROM news ORDER BY create_date DESC";
            $query =mysqli_query($conn,$sql);
            if($query->num_rows <=0)
            {
                echo "<h2>Nincs hír a főoldalon</h2>";
            }else{
        ?>
        <table class="sizingnews">
            <?php while($row = mysqli_fetch_assoc($query)){?>
                <tr>
                    <td class="padtd"><spam class="news_titles"> Szerző:</spam> <?php echo $row["author"]; ?> </td>
                </tr>
                <tr>
                    <td class="padtd"><spam class="news_titles">Közzététel dátuma: </spam><?php echo $row["create_date"]; ?> </td>
                </tr>
                <tr>
                    <td class="padtd">
                        <?php echo $row["article"]; ?> 
                    </td>
                </tr>
                <tr>
                    <td class="padtd">Kedvelések: <?php  $art_id=$row['article_id'];
                                            $query2 = "SELECT COUNT(*) c FROM likes WHERE article_id = $art_id;";
                                                            $result = mysqli_query($conn,$query2);
                                                            $row2 = mysqli_fetch_assoc($result);
                                                            echo $row2['c'];
                                    ?> 
                        <form action="like_dislike.php" method="POST">
                            <input type="text" hidden=true name="nid" value="<?php echo $art_id; ?>">
                            <?php 
                                $check_likes = "SELECT * FROM likes WHERE username='$user' AND article_id=$art_id;";
                                $result = $conn->query($check_likes);
                                if ($result->num_rows > 0)
                                { ?>
                                    <button type = "submit" name="like" disabled>Tetszik</button>
                                    <button type="submit" name="dislike">Mégsem tetszik</button>
                       <?php    }
                                else
                                {?>
                                    <button type = "submit" name="like">Tetszik</button>
                                    <button type="submit" name="dislike" disabled>Mégsem tetszik</button>
                       <?php    }
                                if($_SESSION['level']==1)
                                {
                                    ?>
                                    <button type = "submit" name="delet_n">Bejegyzés törlése</button>
                        <?php   }
                            
                            
                        
                        ?>
                            
                        </form>
                    <hr></td> 
                </tr>
                
            <?php        
            }
        }?>
        </table>
    </div>
    <?php if ($_SESSION['level'] == 1) {?>
            <div class="row p">
                <div class="col-12 col-t-12">
                    <h2>Új Üzenet hozzáadása</h2>
                    <?php 
                            if (isset($_GET['errormsg'])){
                                $errormsg = $_GET['errormsg'];?>
                                <label  class="errorbox textareaerror"><?php echo $errormsg; ?></label><?php
                            }
                    ?>
                    <form action="newpost.php" method="POST">
                         <textarea name="newp" class="textfield" rows="5" cols="10" required="required" id="newp">
                         </textarea><br>
                         <button type="submit" name="feladas" class="btn btn_reg btn_news">Hír hozzáadása</button>
                    </form>
                </div>
            </div>
    <?php }?>
                
    <div class="row">
        <footer class="col-12 col-t-12">
            <p>Az oldal nem reprezentál valós vállalatot, csupán tanítási célokat szolgál.</p>
        </footer>
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