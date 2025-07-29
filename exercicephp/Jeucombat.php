<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php
session_start();
// jeu de combat,Classe personnage

class personnage {
    // Variables
    public $nom;
    public $vie;
    public $force;

    //Construct
    public function __construct($nom, $vie, $force) {
        $this->nom = $nom;
        $this->vie = $vie;
        $this->force = $force;
    }
    // Getter
    public function getNom() {
        return $this->nom;
    }   
    public function getVie() {
        return $this->vie;
    }
    public function getForce() {
        return $this->force;
    }
    // Setter
    public function setNom($nom) {
        return $this->nom = $nom;
    }
    public function setVie($vie) {
        return $this->vie = $vie;
    }
    public function setForce($force) {
        return $this->force = $force;
    }

    // Methode
    public function attaquer($adversaire) {
        if ($this->vie > 0) {
            $degats = $this->force;
            $adversaire->recevoirDegats($degats);
            echo "<p>" . $this->nom . " attaque " . $adversaire->getNom() . " et lui inflige " . $degats . " points de dégâts.</p>";
        } else {
            echo "<p>" . $this->nom . " ne peut pas attaquer, il est hors de combat.</p>";
        }
    }
    // Methode pour recevoir des dégâts
    public function recevoirDegats($degats) {
            
        $this->vie -= $degats;
        if ($this->vie < 0) {
            $this->vie = 0; 

        }
        }
    public function afficherEtat() {
        echo "<p>Nom: " . $this->nom . "<br>";
        echo "Vie: " . $this->vie . "<br>";     
        echo "Force: " . $this->force . "</p>";


        
    // Vérifie si le personnage est hors de combat
        if ($this->vie <= 0) {
            echo "<p>" . $this->nom . " est hors de combat.</p>";
        } else 
            echo "<p>" . $this->nom . " est toujours en vie avec " . $this->vie . " points de vie restants.</p>";
    }
    }
    //Classes filles
    class guerrier extends personnage {
        public function __construct($nom, $vie, $force) {
            $this->nom = $nom;
            $this->vie= $vie;
            $this->force = $force;
            $nom = "Guerrier";
            $vie = 120;
            $force = 15;
        }
        }
    class voleur extends personnage {
        public function __construct($nom, $vie, $force) {
            $this->nom = $nom;
            $this->vie = $vie;
            $this->force = $force;
            $nom = "Voleur";
            $vie = 100;
            $force = 12;
            }
        }   
    class magicien extends personnage { 
        public function __construct($nom, $vie, $force) {
            $this->nom = $nom;
            $this->vie = $vie;
            $this->force = $force;
            $nom = "Magicien";
            $vie = 90;
            $force = 8;
        }
    }

    //affiche les personnages au demarrage

    $guerrier = new guerrier("Guerrier", 120, 15);
    $voleur = new voleur("Voleur", 100, 12);    
    $magicien = new magicien("Magicien", 90, 8);
    $guerrier->afficherEtat();
    $voleur->afficherEtat();
    $magicien->afficherEtat();

    //choix d'un personnage avec sa console
    echo "<p>Choisissez votre personnage: </p>";
    echo "<form method='post'>";
    echo "<select name='personnage'>";
    echo "<option value='guerrier'>Guerrier</option>";
    echo "<option value='voleur'>Voleur</option>";
    echo "<option value='magicien'>Magicien</option>";
    echo "</select>";
    echo "<input type='submit' value='Choisir'>";
    echo "</form>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['personnage'])) {
    $choix = $_POST['personnage'];
    switch ($choix) {
        case 'guerrier':
            $_SESSION['personnage'] = 'guerrier';
            break;
        case 'voleur':
            $_SESSION['personnage'] = 'voleur';
            break;
        case 'magicien':
            $_SESSION['personnage'] = 'magicien';
            break;
    }
    }
    // Reconstruction du personnage choisi depuis la session
if (isset($_SESSION['personnage'])) {
    switch ($_SESSION['personnage']) {
        case 'guerrier':
            $personnageChoisi = new guerrier("Guerrier", 120, 15);
            break;
        case 'voleur':
            $personnageChoisi = new voleur("Voleur", 100, 12);
            break;
        case 'magicien':
            $personnageChoisi = new magicien("Magicien", 90, 8);
            break;
    }
} else {
    echo "<p>Veuillez choisir un personnage avant de lancer le combat.</p>";
    exit;
}

 

    // Reconstruction des adversaires
    $guerrier = new guerrier("Guerrier", 120, 15);
    $voleur = new voleur("Voleur", 100, 12);
    $magicien = new magicien("Magicien", 90, 8);

    // Choix de l’adversaire aléatoire
    $adversaires = array($guerrier, $voleur, $magicien);
    $adversaires = array_filter($adversaires, function($p) use ($personnageChoisi) {
        return $p->getNom() !== $personnageChoisi->getNom();
    });
    $adversaireChoisi = $adversaires[array_rand($adversaires)];
    echo "<p>Votre adversaire est: " . $adversaireChoisi->getNom() . "</p>";

    // Combat
    while ($personnageChoisi->getVie() > 0 && $adversaireChoisi->getVie() > 0) {
        $personnageChoisi->attaquer($adversaireChoisi);
        $adversaireChoisi->afficherEtat();
        if ($adversaireChoisi->getVie() > 0) {
            $adversaireChoisi->attaquer($personnageChoisi);
            $personnageChoisi->afficherEtat();
        }
    }

    // Résultat
    if ($personnageChoisi->getVie() > 0) {
        echo "<p>" . $personnageChoisi->getNom() . " a gagné le combat!</p>";
    } else {
        echo "<p>" . $adversaireChoisi->getNom() . " a gagné le combat!</p>";
    }

    // États finaux
    echo "<p>État final de " . $personnageChoisi->getNom() . ":</p>";
    $personnageChoisi->afficherEtat();
    echo "<p>État final de " . $adversaireChoisi->getNom() . ":</p>";
    $adversaireChoisi->afficherEtat();


?>

        </body>
</html>