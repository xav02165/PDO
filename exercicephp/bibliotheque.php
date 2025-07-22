<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO-bibliotheque</title>
</head>
<body>
    <h1>Bibliothèque - Gestion des livres</h1>  

  <?php
 //connexion a la bdd
        session_start();
        $host = 'localhost';
        $dbname = 'bibliotheque';
        $user = 'root';
        $password = '';


        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           

       
?>


<form method="POST">
    <label>Ajouter un Auteur dans la BDD</label><br>
    <input type="text" name="nom" placeholder="Nom de l'auteur"><br>
    <input type="text" name="prenom" placeholder="Prenom de l'auteur"><br>
    <input type="text" name="nationalité" placeholder="Nationalité de l'auteur"><br>
    <input type="submit" name="submitBook" value="Envoyer le nom de l'auteur dans la BDD">
    <br>
    <br>

    <label>Ajouter un Genre dans la BDD</label><br>
    <input type="text" name="libelle" placeholder="Nom du genre"><br>
    <input type="submit" name="submitGenre" value="Envoyer le genre dans la BDD">
    <br>
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
    <input type="submit" name="submit-Book" value="Envoyer le livre dans la BDD">
    <br>
</form>

<?php
// Insertion d'un auteur dans la base de données
if (isset($_POST['submitName'])) {
    // Récupération des données du formulaire avec validation de base
    $authorName = $_POST['nom'] ?? null;
    $authorPrenom = $_POST['prenom'] ?? null;
    $authorNationalite = $_POST['nationalité'] ?? null; 
    $EcrivainId = $_POST['idecrivain'] ?? null;

    // Vérification que tous les champs requis sont remplis
    if (!empty($authorName) && !empty($authorPrenom) && !empty($authorNationalite)) {
        // Préparation de la requête SQL avec des paramètres nommés pour éviter les injections SQL
        $sql = "INSERT INTO `ecrivains` (`idecrivain`, `nom`, `prenom`, `nationalité`) 
                VALUES (:idecrivain, :nom, :prenom, :nationalite)";
        $stmt = $pdo->prepare($sql);

        // Exécution de la requête avec les données sécurisées
        $stmt->execute([
            ':idecrivain' => $EcrivainId,
            ':nom' => $authorName,
            ':prenom' => $authorPrenom,
            ':nationalite' => $authorNationalite
        ]);

        echo "Auteur ajouté avec succès !";
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
}




// Insertion d'un genre dans la base de données
if (isset($_POST['submitGenre'])) {
    $genreName = $_POST['libelle'];

    $sql = "INSERT INTO `genres` (`libelle`) VALUES ('$genreName')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}



?>
 
<h2> Gestion des Utilisateurs </h2>
<form method="POST">
    <label>Ajouter un Utilisateur</label>
    <input type="text" name="nom_utilisateurs" placeholder="Nom de l'utilisateur">
    <input type="text" name="prenom_utilisateurs" placeholder="Prénom de l'utilisateur">
    <input type="text" name="email_" placeholder="Email de l'utilisateur">
    <select name="idlivres">
        <option value="">Sélectionner un livre</option>
        <?php
        $sqlLivres = "SELECT * FROM livres";
        $stmtLivres = $pdo->prepare($sqlLivres);
        $stmtLivres->execute();
        $resultsLivres = $stmtLivres->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultsLivres as $livre) {
            echo "<option value='" . $livre['id'] . "'>" . $livre['titre'] . "</option>";
        }
        ?>

    
    <input type="submit" name="submitUser" value="Envoyer l'utilisateur dans la BDD">   
</form>   

<?php
// Insertion d'un utilisateur dans la base de données   
if (isset($_POST['submitUser'])) {
    $userName = $_POST['nom_utilisateurs'];
    $userPrenom = $_POST['prenom_utilisateurs'];
    $userEmail = $_POST['email_'];
    $userLivre = $_POST['idlivres'] ?? null;

    $sql = "INSERT INTO `utilisateurs` ( `nom_utilisateurs`, `prenom_utilisateurs`, `email_`,`idlivres` ) VALUES ('$userName', '$userPrenom', '$userEmail', '$userLivre')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
?>

<?php
//Modifier un utilisateur
if (isset($_POST['submitModifierUser'])) {
    $userId = $_POST['id_utilisateurs'];
    $userName = $_POST['nom_utilisateurs'];
    $userPrenom = $_POST['prenom_utilisateurs'];
    $userEmail = $_POST['email_'];

    $sql = "UPDATE `utilisateurs` SET `nom_utilisateurs` = '$userName', `prenom_utilisateurs` = '$userPrenom', `email_` = '$userEmail' WHERE `id_utilisateurs` = $userId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

    //pour delete:
    $sqlAll = "SELECT * FROM `utilisateurs`";
    $stmtAll = $pdo->prepare($sqlAll);
    $stmtAll->execute();
    $users = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        echo "<div>";
        echo "<p>ID: {$user['id']}, Nom: {$user['nom_utilisateurs']}, Prénom: {$user['prenom_utilisateurs']}, Email: {$user['email_']}</p>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='userId' value='{$user['id']}'>";
        echo "<input type='text' name='nom_utilisateurs' value='{$user['nom_utilisateurs']}'>";
        echo "<input type='text' name='prenom_utilisateurs' value='{$user['prenom_utilisateurs']}'>";
        echo "<input type='text' name='email_' value='{$user['email_']}'>";
        echo "<input type='submit' name='submitModifierUser' value='Modifier'>";
        echo "</form>";
        echo "</div>";
    }   
?>


    




</body>
</html>