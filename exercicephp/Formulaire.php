<?php
        //connexion a la bdd
        session_start();
        $host = 'localhost';
        $dbname = 'formulaire';
        $user = 'root';
        $password = '';


        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        

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
    </form> ';
    }
    else {
        echo'<form method="POST">
        <input type="submit" name="deconnexion" value="Se deconnecter">
    </form>';

        echo "Bonjour, " .  $_SESSION['users']['nom_user'] . " " . $_SESSION['users']['prenom_user'] . ". Vous etes connecté.";
    }
    ?>

      

    <?php

        if (isset($_POST['submitConnection'])){
            $id = $_POST['identifiant'];
            $password = $_POST['password'];
            
            $sql = "SELECT * FROM 'users' WHERE adresse_mail_user = $id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

            if ($password == $results[0]["password_user"]){
                $_SESSION['users'] = [
                    "id_user" => $results[0]["id_user"],
                    "nom_user" => $results[0]["nom_user"],
                    "prenom_user" => $results[0]["prenom_user"],
                    "age_user" => $results[0]["age_user"],
                    "adresse_mail_user" =>$results[0]["adresse_mail_user"] ,
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
        
    ?>


</body>
</html>