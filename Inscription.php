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
            <header>Formulaire inscription</header>
            <form action="" method="POST">
                <?php 
                    session_start();
                    require 'connexion.php';
                    if (isset($_POST['valider'])){

                        if (!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['email']) AND !empty($_POST['password'])){
                            $prenom = $nom = $email = "";
                            function securisation($donnee){
                                $donnee = trim($donnee);
                                $donnee = strip_tags($donnee);
                                $donnee = stripslashes($donnee);
                                return $donnee;
                            }

                            $prenom = htmlspecialchars(securisation($_POST['prenom']));
                            $nom = htmlspecialchars(securisation($_POST['nom']));
                            $email = htmlspecialchars(securisation($_POST['email']));
                            $password = sha1($_POST['password']);

                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){?>
                                <div class="error">Desolé, votre email n'est pas valide</div>
                                <?php
                            }else if (!preg_match("/^[a-zA-Z ]*$/",$prenom)){?>
                                <div class="error">Le prenom ne doit contenir que des lettres ou des espaces</div>
                                <?php
                            }else if (!preg_match("/^[a-zA-Z ]*$/",$nom)){?>
                                <div class="error">Le nom ne doit contenir que des lettres ou des espaces</div>
                            <?php
                            }
                            else{
                                $insertUser = $connexion->prepare('INSERT INTO utilisateurs(prenom,nom,email,password) VALUES(?,?,?,?)');
                                $insertUser->execute(array($prenom,$nom,$email,$password));
                                header('Location: login.php');
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
                        <label>Votre prenom</label>
                        <input type="text" placeholder="Votre prenom" name="prenom">
                    </div>

                    <div class="input field">
                        <label>Votre nom</label>
                        <input type="text" placeholder="Votre nom" name="nom">
                    </div>

                    <div class="input field">
                        <label>Email</label>
                        <input type="text" placeholder="Votre email" name="email">
                    </div>

                    <div class="input field">
                        <label>Mot de passe</label>
                        <input type="password" placeholder="Votre mot de passe" name="password">
                    </div>

                    <div class="field image">
                        <label>Select image</label>
                        <input type="file" name="image">
                    </div>

                    <div class="field button">
                        <input type="submit" value="Continue to chat" name="valider">
                    </div>
                </div>                
            </form>
            <div class="link">Already signup? <a href="#">Login now</a></div>
        </section>
    </div>
</body>
</html>