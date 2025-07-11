<?php
/*$host = 'localhost';
$dbname = 'formulaire';
$user = 'root';
$password = '';


    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
    
    // Requete SQL
    $sqlALL = "SELECT * FROM `users`";

    // Preparation + Execution de la requete
    $stmtALL = $pdo->prepare($sqlALL);
    $stmtALL->execute();

    $resultsALL = $stmtALL->fetchAll(PDO::FETCH_ASSOC);
    


    //Fait apparaitre les données de la table 
    foreach ($resultsALL as $key => $value) {
        foreach ($value as $key => $value2) {
            echo $key . " : " . $value2 . " - " ;
        }
        
    }


//update 
   /* foreach ($resultsAll as $key =>$value) {
    $idASupprimer = $value['id_user'];

        echo "<form method='POST'>";
        echo "<input type='hidden' name='idDelete' value='$idASupprimer'>";


        foreach ($value as $key =>$value2) {
        echo $key . " : " . $value2 . " - ";
        }
        //update(1er echo)
        echo '<a href="test.php?id=' . $idASupprimer . '">Modifier</a>';
        
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
    <label for="">Age</label>
    <input type="text" name="AgeUpdate" value="' . $resultsID[0]["age_user"] . '">
    <br>
    <label for="">Mail</label>
    <input type="text" name="MailUpdate" value="' . $resultsID[0]["adresse_mail_user"] . '">
    <br>
    <label for="">Password</label>
    <input type="text" name="PasswordUpdate" value="' . $resultsID[0]["password_user"] . '">
    <br>
    <input type="submit" name="submitUpdate" value="Mettre a jour la BDD">
</form>';

}

if (isset($_POST['submitUpdate'])){

    $idUpdate = $_POST['idUpdate'];
    $nom = $_POST['nomUpdate'];
    $prenom = $_POST['prenomUpdate'];
    $age = $_POST['AgeUpdate'];
    $Mail = $_POST['MailUpdate'];
    $Password = $_POST['PasswordUpdate'];

    $sqlUpdate = "UPDATE `users` SET `nom_user`='$nom', `prenom_user`='$prenom', `age_user`='$age', 'adresse_mail_user'='$Mail', 'password_user'='$Password' WHERE id_vehicule='$idUpdate'";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate ->execute();
}

    }*/

?>