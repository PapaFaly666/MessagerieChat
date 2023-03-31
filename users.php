<?php
    session_start();
    if (!$_SESSION['password']){
        header('Location: login.php');
    }
    require 'connexion.php';
    $recupUser = $connexion->prepare('SELECT * FROM utilisateurs WHERE id = ?');
    $recupUser ->execute(array($_SESSION['id']));
    if ($recupUser->rowCount() > 0) {
        $row = $recupUser->fetch()['prenom']; 
    }

    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Inscription</title>
</head>
<body>
    <div class="boite">
        <section class="users">
            <header>
                
                <div class="content">
                    
                    <img src="images/R.jpg" alt="">
                    <div class="details">
                        <span><?=$row;?></span>
                        <p>Active now</p>
                    </div>
                </div>
                <a href="logout.php" class="logout">Logout</a>
            </header>
            <div class="search">
                <span>Select an user to start chat</span>
                <input type="text" placeholder="Enter nameto search">
                <button><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
            <?php
                $recupAll = $connexion->query('SELECT * FROM utilisateurs');
                if ($recupAll->rowCount() == 1) {
                    $val = "Aucun utilisateur est cconnecté";
                }
                else if ($recupAll->rowCount() > 0){
                    while ($rows = $recupAll->fetch()){
                        if ($rows['id'] != $_SESSION['id']){?>
                            
                            <!--code html-->
                            <div class="users-list">
                                <a href="chat.php?id=<?=$rows['id'];?>">
                                    <div class="content">
                                        <img src="images/R.jpg" alt="">
                                        <div class="details">
                                            <span><?=$rows['prenom'];?></span>
                                            <p>Faites un coucou à <?=$rows['prenom'];?></p>
                                        </div>
                                    </div>
                                    <div class="status-dot"><i class="fa fa-circle" aria-hidden="true"></i></div>
                                </a>
                             </div>
                            <?php
                        }
                        
            
                    }
                }
            ?>
            
            
        </section>
    </div>
</body>
</html>