<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO-bibliotheque</title>
</head>
<body>
    
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


<form method="POST">
    <label>Ajouter un Auteur dans la BDD</label>
    <input type="text" name="nom" placeholder="Nom de l'auteur">
    <input type="submit" name="submitBook" value="Envoyer le nom de l'auteur dans la BDD">
    <br>
    
    <label>Ajouter un Genre dans la BDD</label>
    <input type="text" name="genreName" placeholder="Nom du genre">
    <input type="submit" name="submitGenre" value="Envoyer le genre dans la BDD">
    <br>

    <label>Ajouter un Utilisateur dans la BDD</label>                                   
    <input type="text" name="userName" placeholder="Nom de l'utilisateur">
    <input type="submit" name="submitUser" value="Envoyer le nom de l'utilisateur dans la BDD">
    <br>

    <label>Ajouter un Livre dans la BDD</label>     
    <input type="text" name="bookName" placeholder="Nom du livre">
    <select name="bookAuthor">
        <option value="">Sélectionner un auteur</option>    
        <?php
        $authors = $pdo->query("SELECT * FROM ecrivains")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($authors as $author) {
            echo "<option value='{$author['id']}'>{$author['nom']}</option>";
        }
        ?>
    </select>

    <select name="bookGenre">
        <option value="">Sélectionner un genre</option>
        <?php
        $genres = $pdo->query("SELECT * FROM genres")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($genres as $genre) {
            echo "<option value='{$genre['id']}'>{$genre['libelle']}</option>";
        }
        ?>
    </select>
    <input type="submit" name="submitBook" value="Envoyer le livre dans la BDD">
    <br>
</form>

<?php
// Insertion d'un auteur dans la base de données

    if (isset($_POST['submitName'])) {
    $authorName = $_iPOST['nom'];

    $sql = "INSERT INTO `ecrivains` (`nom`) VALUES ('$authorName')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

// Insertion d'un genre dans la base de données
if (isset($_POST['submitGenre'])) {
    $genreName = $_POST['libelle'];

    $sql = "INSERT INTO `genres` (`libelle`) VALUES ('$genreName')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

// Insertion d'un utilisateur dans la base de données
if (isset($_POST['submitUser'])) {
    $userName = $_POST['nom_utilisateurs'];

    $sql = "INSERT INTO `utilisateurs` (`nom_utilisateurs`) VALUES ('$userName')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

?>
 


 

</body>
</html>