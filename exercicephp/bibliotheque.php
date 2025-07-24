<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PDO-bibliotheque</title>
</head>
<body>
    <h2>Gestion de la Bibliothèque </h2><br>
    <h1> Gestion des Auteurs</h1>  

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
    <label>Ajouter un Auteur dans la BDD</label>
    <input type="text" name="nom" placeholder="Nom de l'auteur">
    <input type="text" name="prenom" placeholder="Prenom de l'auteur">
    <input type="text" name="nationalité" placeholder="Nationalité de l'auteur">
    <input type="submit" name="submitName" value="Envoyer le nom de l'auteur dans la BDD">
    <br>
    <br>

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
?>
<label>Supprimer un Auteur</label>
<form method="POST">
<select name="idecrivain">
    <option value="">Sélectionner un auteur</option>
    <?php   
    $sqlAuthors = "SELECT * FROM ecrivains";
    $stmtAuthors = $pdo->prepare($sqlAuthors);
    $stmtAuthors->execute();
    $resultsAuthors = $stmtAuthors->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultsAuthors as $author) {
        echo "<option value='" . $author['idecrivain'] . "'>" . $author['nom'] . " " . $author['prenom'] . "</option>";
    }
    ?>
</select>
<input type="submit" name="submitDeleteAuthor" value="Supprimer l'auteur">
</form>
<?php
// Supprimer un auteur
if (isset($_POST['submitDeleteAuthor'])) {
    $authorId = $_POST['idecrivain'];

    $sql = "DELETE FROM `ecrivains` WHERE `idecrivain` = :idecrivain";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':idecrivain' => $authorId]);
    echo "Auteur supprimé avec succès !";
}
?>
</form>
<br>
<br>




<h1> Gestion des Genres</h1>

<form method="POST">
    <label>Ajouter un Genre dans la BDD</label>
    <input type="text" name="libelle" placeholder="Nom du genre">
    <input type="submit" name="submitGenre" value="Envoyer le genre dans la BDD">
    <br>
    <br>


<?php
// Insertion d'un genre dans la base de données
if (isset($_POST['submitGenre'])) {
    $genreName = $_POST['libelle'];

    $sql = "INSERT INTO `genres` (`libelle`) VALUES ('$genreName')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

echo "Genre ajouté avec succès !";  
}

?>
</form>
    


    <form method="POST">  
    <label>Supprimer un Genre</label>  
    <select name="idgenre">
    <option value="">Sélectionner un genre</option> 
    <?php   
    $sqlGenres = "SELECT * FROM genres";
    $stmtGenres = $pdo->prepare($sqlGenres);    
    $stmtGenres->execute(); 
    $resultsGenres = $stmtGenres->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultsGenres as $genre) {
        echo "<option value='" . $genre['idgenre'] . "'>" . $genre['libelle'] . "</option>";
    }   
    ?>
</select>

<input type="submit" name="submitDeleteGenre" value="Supprimer le genre">
</form>
<?php
// Supprimer un genre
if (isset($_POST['submitDeleteGenre'])) {
    $genreId = $_POST['idgenre'];   
    $sql = "DELETE FROM `genres` WHERE `idgenre` = :idgenre";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':idgenre' => $genreId]);
    echo "Genre supprimé avec succès !";
}
?>
<br>
<br>

<h1> Gestion des Livres</h1>
<form method="POST">
    <label>Ajouter un Livre dans la BDD</label>     

    <input type="text" name="bookName" placeholder="Nom du livre">
    
       <input type="text" name="annee" placeholder="Année de publication">
       
    <select name="nom">
        <option value="">Sélectionner un auteur</option>
        <?php   
        $sqlAuthors = "SELECT * FROM ecrivains";
        $stmtAuthors = $pdo->prepare($sqlAuthors);
        $stmtAuthors->execute();
        $resultsAuthors = $stmtAuthors->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultsAuthors as $author) {
            echo "<option value='" . $author['idecrivain'] . "'>" . $author['nom'] . " " . $author['prenom'] . "</option>";
        }
        
        ?>


    </select>
        <select name="libelle">
        <option value="">Sélectionner un genre</option>
        <?php   
        $sqlGenres = "SELECT * FROM genres";
        $stmtGenres = $pdo->prepare($sqlGenres);    
        $stmtGenres->execute();
        $resultsGenres = $stmtGenres->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultsGenres as $genre) {
            echo "<option value='" . $genre['idgenre'] . "'>" . $genre['libelle'] . "</option>";
        }
        ?>

    </select>
    <input type="submit" name="submit-Book" value="Envoyer le livre dans la BDD">
    <br>
</form>


<?php
 //insertion d'un livre dans la base de données
if (isset($_POST['submit-Book'])) {
    $bookName = $_POST['bookName'] ?? null;
    $annee = $_POST['annee'] ?? null;
    $genreId = $_POST['libelle'] ?? null;
    $ecrivainId = $_POST['nom'] ?? null;

    if (!empty($bookName) && !empty($annee) && !empty($genreId)) {
        $sql = "INSERT INTO `livres` (`idlivres`,`titre`, `idecrivain`, `annee`, `idgenre`,`id_emprunts`) 
                VALUES (:idlivres, :titre, :idecrivain, :annee, :idgenre, :id_emprunts)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idlivres' => null, // Auto-incrementé par la base de données
            ':titre' => $bookName,
            ':idecrivain' => $ecrivainId,
            ':annee' => $annee,
            ':idgenre' => $genreId,
            ':id_emprunts' => null, 
        ]);
        echo "Livre ajouté avec succès !";

    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
}
?>





 
<h1> Gestion des Utilisateurs </h1>
<form method="POST">
    <label>Ajouter un Utilisateur</label>
    <input type="text" name="nom_utilisateurs" placeholder="Nom de l'utilisateur">
    <input type="text" name="prenom_utilisateurs" placeholder="Prénom de l'utilisateur">
    <input type="email" name="email_" placeholder="Email de l'utilisateur">
    
    <input type="submit" name="submitUser" value="Envoyer l'utilisateur dans la BDD">
<?php
// Insertion d'un utilisateur dans la base de données   
if (isset($_POST['submitUser'])) {
    $userName = $_POST['nom_utilisateurs'];
    $userPrenom = $_POST['prenom_utilisateurs'];
    $userEmail = $_POST['email_'];
    

    $sql = "INSERT INTO `utilisateurs` ( `nom_utilisateurs`, `prenom_utilisateurs`, `email_` ) VALUES ('$userName', '$userPrenom', '$userEmail')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
?>


</form>
<form method="POST">    
<label>Modifier les utilisateurs</label>
<select name="id_utilisateurs">
    <option value="">Sélectionner un utilisateur</option>
    <?php   
    $sqlUsers = "SELECT * FROM utilisateurs";
    $stmtUsers = $pdo->prepare($sqlUsers);
    $stmtUsers->execute();
    $resultsUsers = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultsUsers as $user) {
        echo "<option value='" . $user['id_utilisateurs'] . "'>" . $user['nom_utilisateurs'] . " " . $user['prenom_utilisateurs'] . "</option>";
    }
    ?>
</select>
<input type="text" name="nom_utilisateurs" placeholder="Nouveau nom">   
<input type="text" name="prenom_utilisateurs" placeholder="Nouveau prénom">
<input type="email" name="email_" placeholder="Nouvel email">
<input type="submit" name="submitModifierUser" value="Modifier l'utilisateur">
</form>

<?php
//Modifier un utilisateur
if (isset($_POST['submitModifierUser'])) {
    $userId = $_POST['id_utilisateurs'];
    $userName = $_POST['nom_utilisateurs'];
    $userPrenom = $_POST['prenom_utilisateurs'];
    $userEmail = $_POST['email_'];
    

    $sql = "UPDATE `utilisateurs` SET `nom_utilisateurs` = '$userName', `prenom_utilisateurs` = '$userPrenom', `email_` = '$userEmail',  WHERE `id_utilisateurs` = $userId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}


?>


<form method="POST">
<label>Supprimer un Utilisateur</label>
<select name="id_utilisateurs">
    <option value="">Sélectionner un utilisateur</option>
    <?php   
    $sqlUsers = "SELECT * FROM utilisateurs";
    $stmtUsers = $pdo->prepare($sqlUsers);
    $stmtUsers->execute();
    $resultsUsers = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultsUsers as $user) {
        echo "<option value='" . $user['id_utilisateurs'] . "'>" . $user['nom_utilisateurs'] . " " . $user['prenom_utilisateurs'] . "</option>";
    }
    ?>
</select>
<input type="submit" name="submitDeleteUser" value="Supprimer l'utilisateur">
</form>
<?php
// Supprimer un utilisateur
if (isset($_POST['submitDeleteUser'])) {
    $userId = $_POST['id_utilisateurs'];

    $sql = "DELETE FROM `utilisateurs` WHERE `id_utilisateurs` = :id_utilisateurs";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_utilisateurs' => $userId]);
    echo "Utilisateur supprimé avec succès !";
}
?>
    
    <h1> Gestion des Emprunts</h1>
<form method="POST">
    <label>Ajouter un Emprunt</label>               
    <select name="id_utilisateurs">
        <option value="">Sélectionner un utilisateur</option>
        <?php   
        $sqlUsers = "SELECT * FROM utilisateurs";
        $stmtUsers = $pdo->prepare($sqlUsers);
        $stmtUsers->execute();
        $resultsUsers = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultsUsers as $user) {
            echo "<option value='" . $user['id_utilisateurs'] . "'>" . $user['nom_utilisateurs'] . " " . $user['prenom_utilisateurs'] . "</option>";
        }
        ?>
    </select>
    <select name="idlivres">
        <option value="">Sélectionner un livre</option>
        <?php   
        $sqlBooks = "SELECT * FROM livres";
        $stmtBooks = $pdo->prepare($sqlBooks);
        $stmtBooks->execute();
        $resultsBooks = $stmtBooks->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultsBooks as $book) {
            echo "<option value='" . $book['idlivres'] . "'>" . $book['titre'] . "</option>";
        }
        ?>
    </select>
    <input type="date" name="date_emprunt">
    <input type="submit" name="submitEmprunt" value="Enregistrer l'emprunt">
</form>
<?php
// Insertion d'un emprunt dans la base de données
if (isset($_POST['submitEmprunt'])) {
    $bookId = $_POST['idlivres'] ?? null;
    $dateEmprunt = $_POST['date_emprunt'] ?? null;

    if (!empty($bookId) && !empty($dateEmprunt) && !empty($dateRetour)) {
        $sql = "INSERT INTO `emprunts` (`id_emprunts`, `idlivres`, `date_emprunt`) 
                VALUES (NULL,:idlivres, :date_emprunt)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idlivres' => $bookId,
            ':date_emprunt' => $dateEmprunt,
    
        ]);
        echo "Emprunt enregistré avec succès !";
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<form method="POST">
    <label>Ajouter une date de retour</label>
    <select name="id_emprunts">
        <option value="">Sélectionner un emprunt</option>
        <?php   
        $sqlEmprunts = "SELECT * FROM emprunts";
        $stmtEmprunts = $pdo->prepare($sqlEmprunts);
        $stmtEmprunts->execute();
        $resultsEmprunts = $stmtEmprunts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultsEmprunts as $emprunt) {
            echo "<option value='" . $emprunt['id_emprunts'] . "'>" . $emprunt['id_emprunts'] . "</option>";
        }
        ?>
    </select>
    <input type="date" name="dateRetour">
    <input type="submit" name="submitDateRetour" value="Enregistrer la date de retour">
</form>
<?php
// Insertion d'une date de retour dans la base de données
if (isset($_POST['submitDateRetour'])) {
    $empruntId = $_POST['id_emprunts'] ?? null;
    $dateRetour = $_POST['dateRetour'] ?? null;

    if (!empty($empruntId) && !empty($dateRetour)) {
        $sql = "UPDATE `emprunts` SET `date_retour` = :date_retour WHERE `id_emprunts` = :id_emprunts";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_emprunts' => $empruntId,
            ':date_retour' => $dateRetour,
        ]);
        echo "Date de retour enregistrée avec succès !";
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
}

?>

   
</body>
</html>