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

//supprimer une ligne de bdd avec un bouton submit et hidden
     <hr>
     <?php
foreach ($resultsall as $value) {
    $idASupprimer = $value['id_vehicule'];
    echo "<form method='POST'>";
    echo "<input type='hidden' name='idDelete' value='$idASupprimer'>";

foreach ($value as $key =>$value2){
        echo $key ." : " . $value2 . " - ";
    }
    echo '<input type"submit" name="submitDelete" value="Supprimer"><br>';
    echo "</form>;"
}

if (isset($_POST['submitDelete'])){
    $idToDelete = $_POST['idDelete'];
    $sqlDelete = "DELETE FROM `vehicule` WHERE id_vehicule = '$idToDelete'";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->execute();
}

?>
</body>

</html>

