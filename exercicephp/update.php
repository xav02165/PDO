<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO Connection Example</title>
</head>

<body>

    <form method="POST">
        <label>Ajouter une couleur dans la BDD</label>
        <input type="text" name="colorName">
        <input type="submit" name="submitcolor" value="envoyer la couleur dans la bdd">
        <br>
        <label>Ajouter un type de vehicule dans la BDD</label>
        <input type="text" name="typeName">
        <input type="submit" name="submitType" value="envoyer le type dans la bdd">
    </form>

<?php

$host = 'localhost';
$dbname = 'car';
$user = 'root';
$password = '';


    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";
 
if (isset($_POST['submitVehicule'])){
    $Color = $_POST['selectAddCouleur'];
    $Immatriculation= $_POST['immatriculation']; 
    $Type = $_POST['selectAddType'];


    $sql = "INSERT INTO `vehicule` (`immatriculation`, `id_type`, `id_couleur`) VALUES ('$Immatriculation', '$Color', '$Type')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    
}


if (isset($_POST['submitcolor'])) {
    $Color = $_POST['colorName'];
    $sql = "INSERT INTO `couleurs`(`nom_couleur`) VALUES ('$Color')";
    
    $req = $pdo->prepare($sql);
    $req->execute();
    
}

if (isset($_POST['submitType'])) {
    $Type = $_POST['typeName'];
    $sql = "INSERT INTO `type_vehicule`(`nom_type`) VALUES ('$Type')";
    
    $req = $pdo->prepare($sql);
    $req->execute();
    
}



?>






    <?php
//pour delete:
$sqlAll = "SELECT * FROM `vehicule`";
$stmtAll = $pdo->prepare($sqlAll);
$stmtAll->execute();

$resultsAll = $stmtAll->fetchALL(PDO::FETCH_ASSOC);
//fin php for delete



    
$sqlCouleur = "SELECT * FROM `couleurs`";
$stmtCouleur = $pdo->prepare($sqlCouleur);
$stmtCouleur->execute();

$resultsCouleur = $stmtCouleur->fetchALL(PDO::FETCH_ASSOC);

$sqlType = "SELECT * FROM `type_vehicule`";
$stmtType = $pdo->prepare($sqlType);
$stmtType->execute();

$resultsType = $stmtType->fetchAll(PDO::FETCH_ASSOC);

?>



<form method="POST">
        <label>Ajouter un vehicule</label>
        <input type="text" name="immatriculation">
        <select name="selectAddCouleur">
            <?php
            foreach ($resultsCouleur as $key => $value){
                echo "<option value='" . $value['id_couleur'] . "'>" . $value['nom_couleur'] . " </option>";
            }
            ?>
        </select>
        

        <select name="selectAddType">
            <?php
            foreach ($resultsType as $key => $value){
                echo "<option value='" . $value['id_type'] . "'>" . $value['nom_type'] . " </option>";
            }
            ?>
        </select>

        <input type="submit" name="submitVehicule" value="envoyer le vehicule dans la bdd">
        
    </form>

     <hr>

     <!-- <form method="POST">
    <label for="">ID</label>
    <input type="text" name="idUpdate" value="' . $resultsID[0]['id_vehicule'] . '">
    <br>
    <label for="">immatriculation</label>
    <input type="text" name="immatriculationUpdate" value="' . $resultsID[0]['immatriculation'] . '">
    <br>
    <label for="">type</label>
    <input type="text" name="typeUpdate"value="' . $resultsID[0]['id_type'] . '" >
    <br>
    <label for="">couleur</label>
    <input type="text" name="couleurUpdate" value="' . $resultsID[0]['id_couleur'] . '">
    <br>
    <input type="submit" name="submitUpdate" value="Mettre a jour la BDD">
</form> -->



     <form method="POST">
     <?php
//supprimer une ligne de bdd avec un bouton submit et hidden
foreach ($resultsAll as $key =>$value) {
    $idASupprimer = $value['id_vehicule'];

        echo "<form method='POST'>";
        echo "<input type='hidden' name='idDelete' value='$idASupprimer'>";


        foreach ($value as $key =>$value2) {
        echo $key . " : " . $value2 . " - ";
        }
        //update(1er echo)
        echo '<a href="update.php?id=' . $idASupprimer . '">Modifier</a>';
        echo '<input type="submit" name="submitDelete" value="Supprimer"><br>';
        echo "</form>";

}
if (isset($_POST['submitDelete'])){
    $idToDelete = $_POST['idDelete'];
    $sqlDelete = "DELETE FROM `vehicule` WHERE id_vehicule = '$idToDelete'";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->execute();
}

?>
     </form>
</body>

</html>


<?php
//update


if (isset($_GET["id"])){
    $id = $_GET['id'];
    $sqlID = "SELECT * FROM `vehicule` WHERE id_vehicule = '$id'";

    //preparation + execution de la requete:
    $stmtID = $pdo->prepare($sqlID);
    $stmtID->execute();

    $resultsID = $stmtID->fetchALL(PDO::FETCH_ASSOC);

    echo '<form method="POST">
    <label for="">ID</label>
    <input type="text" name="idUpdate" value="' . $resultsID[0]['id_vehicule'] . '">
    <br>
    <label for="">immatriculation</label>
    <input type="text" name="immatriculationUpdate" value="' . $resultsID[0]["immatriculation"] . '">
    <br>
    <label for="">type</label>
    <input type="text" name="typeUpdate"value="' . $resultsID[0]["id_type"] . '" >
    <br>
    <label for="">couleur</label>
    <input type="text" name="couleurUpdate" value="' . $resultsID[0]["id_couleur"] . '">
    <br>
    <input type="submit" name="submitUpdate" value="Mettre a jour la BDD">
</form>';

}

if (isset($_POST['submitUpdate'])){

    $idUpdate = $_POST['idUpdate'];
    $immatriculation = $_POST['immatriculationUpdate'];
    $type = $_POST['typeUpdate'];
    $couleur = $_POST['couleurUpdate'];

    $sqlUpdate = "UPDATE `vehicule` SET `immatriculation`='$immatriculation', `id_type`='$type', `id_couleur`='$couleur]' WHERE id_vehicule='$idUpdate'";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate ->execute();
}


//fin update
?>

