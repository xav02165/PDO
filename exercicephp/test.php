<?php
$host = 'localhost';
$dbname = 'formulaire';
$user = 'root';
$password = '';


$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Requete SQL
$sqlALL = "SELECT * FROM `users`";

// Preparation + Execution de la requete
$stmtALL = $pdo->prepare($sqlALL);
$stmtALL->execute();

$resultsALL = $stmtALL->fetchAll(PDO::FETCH_ASSOC);



//Fait apparaitre les données de la table 
// foreach ($resultsALL as $key => $value) {
//     foreach ($value as $key => $value2) {
//         echo $key . " : " . $value2 . " - " ;
//     }
// }


// 


// TRUC ?:
//    if (isset($value['id_user'])) {
//         $idASupprimer = $value['id_user'];

//     }



//update 
foreach ($resultsALL as $key => $value) {

    $idUpdate = $value['id_user'];

    foreach ($value as $key => $value2) {
        echo $key . " : " . $value2 . " - ";
        echo '<br>';
    }
    //update(1er echo)
    echo '<a href="Formulaire.php?id=' . $idUpdate . '">Modifier</a>';
    echo '<br>';
    echo '<br>';
}


    if (isset($_GET["id"])) {
        $id = $_GET['id'];
        $sqlID = "SELECT * FROM `users` WHERE id_user = '$id'";

        //preparation + execution de la requete:
        $stmtID = $pdo->prepare($sqlID);
        $stmtID->execute();

        $resultsID = $stmtID->fetchALL(PDO::FETCH_ASSOC);

        echo '<form method="POST">
    <label for=""></label>
    <input type="hidden" name="idUpdate" value="' . htmlspecialchars($resultsID[0]['id_user']) . '">
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

    if (isset($_POST['submitUpdate'])) {

        $idUpdate = $_POST['idUpdate'];
        $nom = $_POST['nomUpdate'];
        $prenom = $_POST['prenomUpdate'];
        $age = $_POST['AgeUpdate'];
        $Mail = $_POST['MailUpdate'];
        $Password = $_POST['PasswordUpdate'];

        $hashedPassword =  password_hash($Password, PASSWORD_DEFAULT);


        // UPDATE `users` SET `id_user`='[value-1]',`nom_user`='[value-2]',`prenom_user`='[value-3]',`age_user`='[value-4]',`adresse_mail_user`='[value-5]',`password_user`='[value-6]' WHERE 1
        $sqlUpdate = "UPDATE `users` SET `nom_user`='$nom', `prenom_user`='$prenom', `age_user`='$age', `adresse_mail_user`='$Mail', `password_user`='$hashedPassword' WHERE id_user='$idUpdate'";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute();
    }

?>