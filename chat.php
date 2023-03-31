<?php 
    session_start();
    require 'connexion.php';
    if (!$_SESSION['password']){
        header('Location: login.php');
    }

    if (isset($_GET['id']) AND !empty($_GET['id'])){
        $getId = $_GET['id'];
        $recupAllUsers = $connexion->prepare('SELECT * FROM utilisateurs WHERE id=?');
        $recupAllUsers->execute(array($getId));
        if ($recupAllUsers->rowCount() > 0){
            $row = $recupAllUsers->fetch()['prenom'];
            if (isset($_POST['envoyer'])){
                $message = htmlspecialchars($_POST['message']);
                $insert = $connexion->prepare('INSERT INTO messages(message,idAuteur,idDestination) VALUES(?,?,?)');
                $insert->execute(array($message,$_SESSION['id'],$getId));
            }
        }
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
        <section class="chat-area">
            <header>
                <a href="users.php"class="back-icon"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                <img src="images/R.jpg" alt="">
                <div class="details">
                    <span><?=$row;?></span>
                    <p>Active now</p>
                </div>
            </header>
            <div class="chat-box">
            <?php
                        $recupMessage = $connexion->prepare('SELECT * FROM messages WHERE idAuteur=? AND idDestination=? OR idDestination=? AND idAuteur=?');
                        $recupMessage->execute(array($_SESSION['id'], $getId,$_SESSION['id'],$getId));
                        while ($message = $recupMessage->fetch()){
                            if ($message['idDestination'] == $getId){?>
                                <!--Code html -->
                            <div class="chat outgoing"> 
                                <div class="details">
                                    <p><?=$message['message'];?></p>
                                </div>
                            </div>
                        <?php
                        }elseif ($message['idDestination'] == $_SESSION['id']){
                            ?>
                                <div class="chat incoming">
                                    <img src="images/R.jpg" alt="">
                                    <div class="details">
                                        <p><?=$message['message'];?></p>
                                    </div>
                                </div>

                            <?php
                        }
                            }
                        ?>

            </div>
            <form action="" class="typing-area" method="POST">
                <input type="text" placeholder="Type a message here..." name="message">
                <button name="envoyer" type="submit"><i class="fa fa-telegram" aria-hidden="true"></i></button>
            </form>
        </section>
    </div>
</body>
</html>