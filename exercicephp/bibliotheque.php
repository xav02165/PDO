<?php

        //connexion a la bdd
        session_start();
        $host = 'localhost';
        $dbname = 'bibliotheque';
        $user = 'root';
        $password = '';


        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie !";
           
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
 <?php

    if (!isset($_SESSION['utilisateurs'])){
        echo '<form method="POST">
        <label>Nom</label>
        <input type="text" name="nom_utilisateurs">
        <br>
        <label>Prenom</label>
        <input type="text" name="prenom_utilisateurs">
        <br>
        <label>Email</label>
        <input type="email" name="email_">
        <br>
        <input type="submit" name="submitConnexion" value="Se connecter">
        
        </form><a href="?page=createAccount" ><p>Pas de compte ? créez en un ici! <p></a>';
    }
    else {
        echo'<form method="POST">
        <input type="submit" name="deconnexion" value="Se deconnecter">
        <br>
        
        </form>';

        echo "Bonjour,  Vous etes connecté.";
        echo '<br>';
        echo '<hr>';
    }
    
    ?>



<?php

        if (isset($_POST['submitConnexion'])){
            $nom = $_POST['nom_utilisateurs'];
            $prenom = $_POST['prenom_utilisateurs'];
            $email = $_POST['email_'];
            
            $sql = "SELECT * FROM `utilisateurs` WHERE email_ = '$nom'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

            //password_verify pour le hachage inversé
            if (password_verify($nom, $results[0]["nom_utilisateurs"])) {
                $_SESSION['utilisateurs'] = [
                    "nom_utilisateurs" => htmlspecialchars($results[0]["nom_utilisateurs"]),
                    "prenom_utilisateurs" => htmlspecialchars($results[0]["prenom_utilisateurs"]),
                    "email_" =>htmlspecialchars($results[0]["email_"]) 
                ];
                header ("Location: bibliotheque.php");
        }
            else {
                echo"utilisateur non connecté - Mot de passe incorrect";
            }
        }

        if (isset($_POST['deconnexion'])){
            session_destroy();
            header("Location: bibliotheque.php");
        }
        
        //create count
        if (isset($_GET['page']) && $_GET['page'] == 'createAccount'){
            echo '<form method="POST">
            <label> Nom</label>
        <input type="text" name="nom_utilisateurs">
        
        <br>
        <label>Prenom</label>
        <input type="text" name="prenom_utilisateurs">
        
        <br>
        <label>Adresse mail </label>
        <input type="text" name="email_">
        
       
        <br>
        <input type="submit" name="submitNom" value="Creer mon compte">
        </form>';
        }
    ?>

</body>
</html>