<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>
    <div class="boite">
        <section class="form login">
            <header>Connexion</header>
            <form action="" method="POST">
                <?php 
                session_start();
                    if (isset($_POST['valider'])){
                        if (!empty($_POST['email']) AND !empty($_POST['password'])){
                            require 'connexion.php';
                            $email = htmlspecialchars($_POST['email']);
                            $password = sha1($_POST['password']);
                            $recupUser = $connexion->prepare('SELECT * FROM utilisateurs WHERE email = ? AND password = ?');
                            $recupUser->execute(array($email,$password));
                            if ($recupUser->rowCount()>0){
                                $_SESSION['email'] = $email;
                                $_SESSION['password'] = $password;
                                $_SESSION['id'] = $recupUser->fetch()['id'];
                                $_SESSION['prenom'] = $recupUser->fetch()['prenom'];
                                header('Location: users.php');
                            }
                            else{
                                ?>
                                    <div class="error">Votre email ou mot de passe est incorrect</div>
                                <?php
                            }
                        }else{
                            ?>
                           <div class="error">Veuillez remplir le champs vide</div>
                           <?php
                        }
                    }
                ?>
                <div class="details">
                    <div class="input field">
                        <label>Email</label>
                        <input type="text" placeholder="Votre email" name="email">
                    </div>

                    <div class="input field">
                        <label>Mot de passe</label>
                        <input type="password" placeholder="Votre mot de passe" name="password">
                    </div>
                </div> 
                
                <div class="field button">
                    <input type="submit" value="Connexion" name="valider">
                </div>
            </form>
            <div class="link">Not yet signed up? <a href="#">Login now</a></div>
        </section>
    </div>
</body>
</html>