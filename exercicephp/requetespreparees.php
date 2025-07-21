    
    <?php
// attention code non fonctionnel dans l'etat, exemple uniquement, voir fichier Formulaire.php
       

    if (isset($_POST['submit'])){
        $name = $_POST['name'];
        $firstName = $_POST['firstName'];
        $age = $_POST['age'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        
        $sql = "INSERT INTO `users`(`nom_user`, `prenom_user`, `age_user`, `adresse_mail_user`, `password_user`) VALUES (:nom,:prenom,:age,:mail,:motDePass)";
        // 
        // Préparation + Execution de la requête
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nom', $name);
        $stmt->bindParam(':prenom', $firstName);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':motDePass', $password);


        $stmt->execute();
    }

    // ou:

        if (isset($_POST['submit'])){
        $name = $_POST['name'];
        $firstName = $_POST['firstName'];
        $age = $_POST['age'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        
        $sql = "INSERT INTO `users`(`nom_user`, `prenom_user`, `age_user`, `adresse_mail_user`, `password_user`) VALUES (?,?,?,?,?)";
        // 
        // Préparation + Execution de la requête
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $firstName, $age, $mail, $password]);
    }


    // Pour contrer les failles XSS
htmlspecialchars($results[0]["id_user"])
?>