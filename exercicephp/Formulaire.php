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
        <br>
        <label>Ajouter un nom dans la Bdd</label>
        <input type="text" name="nom_user1">
        
        <br>
        <label>Ajouter un prenom dans la BDD</label>
        <input type="text" name="prenom_user1">
        
        <br>
        <label>Ajouter une adresse mail dans la Bdd</label>
        <input type="text" name="adresse_mail_user1">
        
        <br>
        <label>Ajouter un age dans la BDD</label>
        <input type="text" name="age_user1">
        
        <br>
        <label>Ajouter un password dans la Bdd</label>
        <input type="text" name="password_user1">
        <input type="submit" name="submitNom" value="creer une nouvelle fiche dans la Bdd">
        </form>';

        echo "Bonjour, " .  $_SESSION['users']['nom_user'] . " " . $_SESSION['users']['prenom_user'] . ". Vous etes connecté.";
        
        
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

    
<?php
 if (isset($_POST['submitNom'])) {
        $Nom = $_POST['nom_user1'];
        $Prenom = $_POST['prenom_user1'];
        $Mail = $_POST['adresse_mail_user1'];
        $Age = $_POST['age_user1'];
        $Password = $_POST['password_user1'];

        $sql = "INSERT INTO `users` (`nom_user`, `prenom_user`, `adresse_mail_user`, `age_user`, `password_user`) VALUES ('$Nom', '$Prenom', '$Mail','$Age', '$Password')";

        $req = $pdo->prepare($sql);
        $req->execute();
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

<?php

//Update
if (isset($_GET["id"])){
    $id = $_GET['id'];
    $sqlID = "SELECT * FROM `users` WHERE id_user = '$id'";

    //preparation + execution de la requete:
    $stmtID = $pdo->prepare($sqlID);
    $stmtID->execute();

    $resultsID = $stmtID->fetchALL(PDO::FETCH_ASSOC);

    echo '<form method="POST">
    <label for="">ID</label>
    <input type="text" name="idUpdate" value="' . $resultsID[0]['id_user'] . '">
    <br>
    <label for="">Nom</label>
    <input type="text" name="nomUpdate" value="' . $resultsID[0]["nom_user"] . '">
    <br>
    <label for="">Prenom</label>
    <input type="text" name="prenomUpdate"value="' . $resultsID[0]["prenom_user"] . '" >
    <br>
    <label for="">age</label>
    <input type="text" name="ageUpdate" value="' . $resultsID[0]["age_user"] . '">
    <br>
    <label for="">Mail</label>
    <input type="text" name="mailUpdate" value="' . $resultsID[0]["adresse_mail_user"] . '">
    <br>
    <label for="">Password</label>
    <input type="text" name="passwordUpdate" value="' . $resultsID[0]["password_user"] . '">
    
    <input type="submit" name="submitUpdate" value="Mettre a jour la BDD">
</form>';

}

if (isset($_POST['submitUpdate'])){

    $idUpdate = $_POST['idUpdate'];
    $nom = $_POST['nomUpdate'];
    $Prenom = $_POST['prenomUpdate'];
    $Age = $_POST['ageUpdate'];
    $Mail = $_POST['mailUpdate'];
    $Password = $_Post['passwordUpdate'];

    $sqlUpdate = "UPDATE `users` SET  `nom_user`='$nom', `prenom_user`='$Prenom', `age_user`='$Age', `adresse_mail_user`='$Mail', `password_user`='$Password' WHERE id_user='$idUpdate'";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate ->execute();
}
?>


</body>
</html>