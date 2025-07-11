<?php
        //connexion a la bdd
        session_start();
        $host = 'localhost';
        $dbname = 'formulaire';
        $user = 'root';
        $password = '';


        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie !";


?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormulairePHP</title>
</head>

<body>
   
    <?php

    if (!isset($_SESSION['users'])){
        echo '<form method="POST">
        <label>Identifiant</label>
        <input type="text" name="identifiant">
        <label>Password</label>
        <input type="password" name="password">
        <input type="submit" name="submitConnexion" value="Se connecter">
        
        </form><a href="?page=createAccount" ><p>Pas de compte ? créez en un ici! <p></a>';
    }
    else {
        echo'<form method="POST">
        <input type="submit" name="deconnexion" value="Se deconnecter">
        <br>
        
        </form>';

        echo "Bonjour, " .  htmlspecialchars($_SESSION['users']['nom_user']) . " " . $_SESSION['users']['prenom_user'] . ". Vous etes connecté.";
        echo '<br>';
        echo '<hr>';
        include 'test.php';
    }
    
    ?>

      

    <?php

        if (isset($_POST['submitConnexion'])){
            $id = $_POST['identifiant'];
            $password = $_POST['password'];
            
            $sql = "SELECT * FROM `users` WHERE adresse_mail_user = '$id'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

            //password_verify pour le hachage inversé
            if (password_verify($password, $results[0]["password_user"])){
                $_SESSION['users'] = [
                    "id_user" => htmlspecialchars($results[0]["id_user"]),
                    "nom_user" => htmlspecialchars($results[0]["nom_user"]),
                    "prenom_user" => htmlspecialchars($results[0]["prenom_user"]),
                    "age_user" => htmlspecialchars($results[0]["age_user"]),
                    "adresse_mail_user" =>htmlspecialchars($results[0]["adresse_mail_user"]) ,
                ];
                header("Location: Formulaire.php");
            }
            else {
                echo"utilisateur non connecté - Mot de passe incorrect";
            }
        }

        if (isset($_POST['deconnexion'])){
            session_destroy();
            header("Location: Formulaire.php");
        }
        
        //create count
        if (isset($_GET['page']) && $_GET['page'] == 'createAccount'){
            echo '<form method="POST">
            <label> Nom</label>
        <input type="text" name="nom_user1">
        
        <br>
        <label>Prenom</label>
        <input type="text" name="prenom_user1">
        
        <br>
        <label>Adresse mail </label>
        <input type="text" name="adresse_mail_user1">
        
        <br>
        <label>Age</label>
        <input type="text" name="age_user1">
        
        <br>
        <label>Password</label>
        <input type="text" name="password_user1">
        <br>
        <input type="submit" name="submitNom" value="Creer mon compte">
        </form>';
        }
    ?>

    <hr>
<?php
 if (isset($_POST['submitNom'])) {
        $Nom = $_POST['nom_user1'];
        $Prenom = $_POST['prenom_user1'];
        $Mail = $_POST['adresse_mail_user1'];
        $Age = $_POST['age_user1'];
        $Password = $_POST['password_user1'];

        //fonction de hachage pour le password
        $hashedPassword =  password_hash($Password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` (`nom_user`, `prenom_user`, `adresse_mail_user`, `age_user`, `password_user`) VALUES ('$Nom', '$Prenom', '$Mail','$Age', '$hashedPassword')";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }




    


    if (isset($_POST['submitPrenom'])) {
        $Prenom = $_POST['prenom_user1'];
        $sql = "INSERT INTO  `users` (`prenom_user`) VALUES ('$Prenom')";

        $req = $pdo->prepare($sql);
        $req->execute();
    }


    if (isset($_POST['submitAdresse_mail-user'])) {
        $Mail = $_POST['adresse_mail_user1'];
        $sql = "INSERT INTO  `users` (`adresse_mail_user`) VALUES ('$Mail')";

        $req = $pdo->prepare($sql);
        $req->execute();
    }


    if (isset($_POST['submitAge'])) {
        $Age = $_POST['age_user1'];
        $sql = "INSERT INTO `users` (`age_user`) VALUES ('$Age')";

        $req = $pdo->prepare($sql);
        $req->execute();
    }


    if (isset($_POST['submitpassword'])) {
        $Password = $_POST['password_user1'];
        $sql = "INSERT INTO `users` (`password_user`) VALUES ('$Password')";

        $req = $pdo->prepare($sql);
        $req->execute();
    }


    ?>





</body>
</html>