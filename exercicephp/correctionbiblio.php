<?php
// Connexion à la bdd

$host = 'localhost';
$dbname = 'biblio';
$user = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
// Active les erreurs PDO en exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php?page=livres">Livre</a></li>
            <li><a href="index.php?page=auteurs">Auteurs</a></li>
            <li><a href="index.php?page=genres">Genres</a></li>
            <li><a href="index.php?page=utilisateurs">Utilisateurs</a></li>
            <li><a href="index.php?page=listeEmprunts">Emprunts</a></li>
        </ul>
        <ul>
            <li><a href="index.php?page=addLivres">Ajouter livre</a></li>
            <li><a href="index.php?page=addAuteurs">Ajouter auteurs</a></li>
            <li><a href="index.php?page=addGenres">Ajouter genres</a></li>
            <li><a href="index.php?page=addUtilisateurs">Ajouter utilisateurs</a></li>
        </ul>
    </nav>
    <hr>



    <?php


// Read
// Gestion des livres
if (isset($_GET['page']) && $_GET['page'] == "livres"){

    $sqlReadLivre = "SELECT * FROM `livres`
                    INNER JOIN `genres` ON livres.idGenre = genres.idGenre
                    INNER JOIN `auteurs` ON livres.idAuteur = auteurs.idAuteur";
    $stmtReadLivre = $pdo->prepare($sqlReadLivre);
    $stmtReadLivre->execute();

    $resultsLivres = $stmtReadLivre->fetchAll(PDO::FETCH_ASSOC);

    

?>
<table>
  <thead>
    <tr>
      <th scope="col">Nom du livre</th>
      <th scope="col">Année de parution</th>
      <th scope="col">Auteur</th>
      <th scope="col">Genre</th>
      <th scope="col">Disponible</th>
      <th scope="col">Emprunter</th>
    </tr>
  </thead>
 
  <tbody>
    <tr>
        <?php
            foreach ($resultsLivres as $key => $value) {
                if ($value['disponibilite']  === "1"){
                    $value['disponibilite'] = "Oui";
                }
                else{
                    $value['disponibilite'] = "Non";
                }

                echo '<tr>
                      <td scope="row">' . $value['nomLivre'] . '</th>
                      <td>' . $value['annee'] . '</td>
                      <td>' . $value['nomAuteur'] . '</td>
                      <td>' . $value['libelleGenre'] . '</td>
                      <td>' . $value['disponibilite'] . '</td>
                      <td>
                       <a href="index.php?page=emprunts&idLivre=' . $value['idLivre'] . '"><button';
                                if ($value['disponibilite'] === "Non"){
                    echo " disabled";
                }   
                       echo '>Emprunter</button></a>
                </td>
                      </tr>';
            }

        ?>

    </tr>
  </tbody>
</table>

<?php
    }
// Gestion des auteurs
if (isset($_GET['page']) && $_GET['page'] == "auteurs"){
    echo $_GET['page'];
    
    }


// Gestion des genres
    if (isset($_GET['page']) && $_GET['page'] == "genres"){
        echo $_GET['page'];

    }


// Gestion des utilisateurs
if (isset($_GET['page']) && $_GET['page'] == "utilisateurs"){


        $sqlReadUsers = "SELECT * FROM `utilisateurs`";
        $stmtReadUsers = $pdo->prepare($sqlReadUsers);
        $stmtReadUsers->execute();

        $resultsUsers = $stmtReadUsers->fetchAll(PDO::FETCH_ASSOC);
    
        var_dump($resultsUsers);
    }


if (isset($_GET['page']) && $_GET['page'] == "listeEmprunts"){


        $sqlReadAllEmprunts = "SELECT * FROM `emprunter`
INNER JOIN `livres` ON livres.idLivre = emprunter.idLivre
INNER JOIN `auteurs` ON livres.idAuteur = auteurs.idAuteur
INNER JOIN `genres` ON livres.idGenre = genres.idGenre
INNER JOIN `utilisateurs` ON utilisateurs.idUtilisateur = emprunter.idUtilisateur";
        $stmtReadAllEmprunts = $pdo->prepare($sqlReadAllEmprunts);
        $stmtReadAllEmprunts->execute();

        $resultsAllEmprunts = $stmtReadAllEmprunts->fetchAll(PDO::FETCH_ASSOC);
    
?>
    <table>
        <thead>
            <tr>
            <th scope="col">Nom du livre</th>
            <th scope="col">Année de parution</th>
            <th scope="col">Auteur</th>
            <th scope="col">Genre</th>
            <th scope="col">Nom et Prénom emprunteur</th>
            <th scope="col">Retour livre</th>
            </tr>
        </thead>
        
        <tbody>
            <tr>

        
                <?php

                    foreach ($resultsAllEmprunts as $key => $value) {
                        echo '<tr>
                      <td>'. $value['nomLivre'] .'</th>
                      <td>'. $value['annee'] .'</td>
                      <td>'. $value['nomAuteur'] .'</td>
                      <td>'. $value['libelleGenre'] .'</td>
                      <td>'. $value['nomUtilisateur'] . ' ' . $value['prenomUtilisateur']  .'</td>
                      <td><form method="POST">
                        <input type="hidden" name="idLivre" value="' . $value['idLivre'] . '">
                        <input type="hidden" name="idEmprunt" value="' . $value['idEmprunt'] . '">
            <input type="submit" name="retourLivre" value="retour livre">
        </form></td>
                      </tr>';
                    }
                ?>
            </tr>
        </tbody>
    </table>

<?php

                    if(isset($_POST['retourLivre'])){
                        $date = date("d.m.y");
                        $idEmprunt = $_POST['idEmprunt'] ;
                        $idLivre = $_POST['idLivre'];
                        $sqlUpdateRetour = "UPDATE `livres` SET `disponibilite`='1' WHERE idLivre = $idLivre;
                        UPDATE `emprunter` SET `dateRetourEmprunt`='$date' WHERE idEmprunt = $idEmprunt;";

                        $stmtUpdateRetour = $pdo->prepare($sqlUpdateRetour);
                        $stmtUpdateRetour->execute();
                    }

}

// Gestion des emprunts
    if (isset($_GET['page']) && $_GET['page'] == "emprunts"){

        $sqlReadUsers = "SELECT * FROM `utilisateurs`";
        $stmtReadUsers = $pdo->prepare($sqlReadUsers);
        $stmtReadUsers->execute();

        $resultsUsers = $stmtReadUsers->fetchAll(PDO::FETCH_ASSOC);

        echo '<form method="POST">
                <select name="userName">';
              
        foreach ($resultsUsers as $key => $value) {
            echo '<option value="' . $value['idUtilisateur'] .'">' . $value['nomUtilisateur'] . ' ' . $value['prenomUtilisateur'] . '</option>';
        };
                

        echo '</select>
                <input type="submit" name="addEmprunt" value="Emprunter le livre">
            </form>';
    }

    if (isset($_POST['addEmprunt'])){
        $idLivre = $_GET['idLivre'];
        $idUser = $_POST['userName'];
        $dateEmprunt = date("d.m.y");
        $dateRetour = "-";
        echo "j'emprunte un livre" . $idLivre . " - " . $idUser;

        $sqlAddEmprunt = "INSERT INTO `emprunter`(`idLivre`, `idUtilisateur`, `dateEmprunt`, `dateRetourEmprunt`) VALUES (:idLivre, :idUser, :dateEmprunt , :dateRetour); UPDATE `livres` SET `disponibilite`='0' WHERE idLivre = $idLivre;";

        $stmtAddEmprunt = $pdo->prepare($sqlAddEmprunt);

        echo $sqlAddEmprunt;
        $stmtAddEmprunt->bindParam(':idLivre', $idLivre);
        $stmtAddEmprunt->bindParam(':idUser', $idUser);
        $stmtAddEmprunt->bindParam(':dateEmprunt', $dateEmprunt);
        $stmtAddEmprunt->bindParam(':dateRetour', $dateRetour);

        $stmtAddEmprunt->execute();

    
    }

// Create
// Ajouter un livre
    if (isset($_GET['page']) && $_GET['page'] == "addLivres"){

        // Read Auteurs
        $sqlReadAuteur = "SELECT * FROM `auteurs`";
        $stmtReadAuteur = $pdo->prepare($sqlReadAuteur);
        $stmtReadAuteur->execute();

        $resultsAuteur = $stmtReadAuteur->fetchAll(PDO::FETCH_ASSOC);

        echo "<br>";
        // Read Genre
        $sqlReadGenre = "SELECT * FROM `genres`";
        $stmtReadGenre = $pdo->prepare($sqlReadGenre);
        $stmtReadGenre->execute();
        
        $resultsGenre = $stmtReadGenre->fetchAll(PDO::FETCH_ASSOC);

        
        echo '<form method="POST">
        <label>Nom du livre</label>
        <input type="text" name="nomLivre">
        <br>
        <label>Année de parution</label>
        <input type="text" name="annee">
        <br>
        <select name="auteur">';
        foreach ($resultsAuteur as $key => $value) {
            echo '<option value="' . $value['idAuteur'] .'">'. $value['nomAuteur'] .'</option>';    
        }
    
    
        echo   '</select>
            <br>
            <select name="genre">';
        foreach ($resultsGenre as $key => $value) {
            echo '<option value="' . $value['idGenre'] .'">'. $value['libelleGenre'] .'</option>';    
        }
        
        echo '</select>
            <input type="submit" name="submitCreateLivre" value="Ajouter le livre">
        </form>';


        if (isset($_POST['submitCreateLivre'])){
            $nomLivre = $_POST['nomLivre'];
            $anneeLivre = $_POST['annee'];
            $auteurLivre = $_POST['auteur'];
            $genreLivre = $_POST['genre'];

            $sqlCreateLivre = "INSERT INTO `livres`(`nomLivre`, `annee`, `disponibilite`, `idAuteur`, `idGenre`) VALUES (:nom, :annee, '1', :auteur, :genre)";
            $stmtCreateLivre = $pdo->prepare($sqlCreateLivre);

            $stmtCreateLivre->bindParam(':nom', $nomLivre);
            $stmtCreateLivre->bindParam(':annee', $anneeLivre);
            $stmtCreateLivre->bindParam(':auteur', $auteurLivre);
            $stmtCreateLivre->bindParam(':genre', $genreLivre);

            $stmtCreateLivre->execute();

            echo "Livre ajouté en bdd";
        }

    }
// Ajouter un auteur
    if (isset($_GET['page']) && $_GET['page'] == "addAuteurs"){

        echo    '<form method="POST">
                    <input type="text" name="addAuteur">
                    <input type="submit" name="createAuteur" value="Ajouter auteur">
                </form>';

        if (isset($_POST['createAuteur'])){
            $auteur = $_POST['addAuteur'];
            
            $sqlAddAuteur = "INSERT INTO `auteurs`(`nomAuteur`) VALUES (:nom)";
            $stmtAddAuteur = $pdo->prepare($sqlAddAuteur);

            $stmtAddAuteur->bindParam(':nom', $auteur);

            $stmtAddAuteur->execute();

            echo "Auteur ajouté";
        }

    }
// Ajouter un genre
    if (isset($_GET['page']) && $_GET['page'] == "addGenres"){

        echo    '<form method="POST">
            <input type="text" name="addGenre">
            <input type="submit" name="createGenre" value="Ajouter Genre">
        </form>';

        if (isset($_POST['createGenre'])){
            $genre = $_POST['addGenre'];
            
            $sqlAddGenre = "INSERT INTO `genres`(`libelleGenre`) VALUES (:nom)";
            
            $stmtAddGenre = $pdo->prepare($sqlAddGenre);
            $stmtAddGenre->bindParam(':nom', $genre);

            $stmtAddGenre->execute();

            echo "Genre ajouté";
        }

    }
// Ajouter un utilisateur
    if (isset($_GET['page']) && $_GET['page'] == "addUtilisateurs"){
    
    echo    '<form method="POST">
            <input type="text" name="addNomUser" placeholder="Nom Utilisateur">
            <input type="text" name="addPrenomUser" placeholder="Prénom Utilisateur">
            <input type="text" name="addEmailUser" placeholder="Email Utilisateur">
            <input type="submit" name="createUser" value="Ajouter un utilisateur">
        </form>';

        if (isset($_POST['createUser'])){
            $nom = $_POST['addNomUser'];
            $prenom = $_POST['addPrenomUser'];
            $email = $_POST['addEmailUser'];
            
            $sqlAddUser = "INSERT INTO `utilisateurs`(`nomUtilisateur`, `prenomUtilisateur`, `email`) VALUES (:nom, :prenom, :email)";
            
            $stmtAddUser = $pdo->prepare($sqlAddUser);
            $stmtAddUser->bindParam(':nom', $nom);
            $stmtAddUser->bindParam(':prenom', $prenom);
            $stmtAddUser->bindParam(':email', $email);

            $stmtAddUser->execute();

            echo "Utilisateur ajouté";
        }

    }
    ?>

</body>
</html>

<?php 
// Livres
// Lister tous les livres avec leur auteur et leur genre,
// Ajouter un nouveau livre,
// Modifier un livre,
// Supprimer un livre,
// Afficher si le livre est disponible ou non,

// Écrivains
// Gérer (CRUD) les écrivains (nom, prénom, nationalité),
// Associer un livre à un écrivain,

// Genres
// Gérer les genres (CRUD),

// Utilisateurs
// Gérer les utilisateurs (CRUD) -- Id nom prenom email,

// Emprunts
// Enregistrer un emprunt (sélection du livre et de l’utilisateur, date du jour),
// Marquer un emprunt comme rendu,
// Afficher l’historique des emprunts d’un utilisateur,
// Empêcher l’emprunt d’un livre déjà emprunté