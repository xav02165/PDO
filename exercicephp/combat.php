
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
.health-bar {
  width: 200px;
  background-color: #ddd;
  border-radius: 5px;
  margin-bottom: 10px;
}
.health-fill {
  height: 20px;
  background-color: #4CAF50;
  border-radius: 5px;
  text-align: center;
  color: white;
  line-height: 20px;
  font-size: 12px;
}
</style>
<style>
.fantome {
  animation: apparition 1s ease-out;
  color: #7f00ff;
  font-weight: bold;
}
@keyframes apparition {
  0% { opacity: 0; transform: translateY(-20px); }
  100% { opacity: 1; transform: translateY(0); }
}
</style>

</head>
<body>
    

<?php
session_start();

// Classe de base
class personnage {
    public $nom;
    protected $vie;
    protected $force;

    public function subirDegats($degats) {
        $this->vie -= $degats;
        echo " $degats dégâts subis ! PV restants : {$this->vie}<br>";

    }
    public function afficherBarreVie() {
    $pourcentage = ($this->vie / 120) * 100; // à adapter selon le max de PV
    if ($pourcentage < 0) $pourcentage = 0;

    echo "<div class='health-bar'>";
    echo "<div class='health-fill' style='width:{$pourcentage}%;'>" . intval($this->vie) . " PV</div>";
    echo "</div>";
}

    //Constructeur
    public function __construct($nom, $vie, $force) {
        $this->nom = $nom;
        $this->vie = $vie;
        $this->force = $force;
    }

    //Getter
    public function getNom() {
        return $this->nom;
    }
    public function getVie() {
        return $this->vie;
    }
    public function getForce() {
        return $this->force;
    }

    //Setter
    public function setVie($vie) {
        $this->vie = $vie;
    }

    // Méthode
    public function attaquer($adversaire) {
        if ($this->vie > 0) {
            $degats = $this->force;
            $adversaire->recevoirDegats($degats);
            echo "<p>$this->nom attaque " . $adversaire->getNom() . " et inflige $degats dégâts.</p>";
        } else {
            echo "<p>$this->nom est hors de combat et ne peut pas attaquer.</p>";
        }
    }

    public function recevoirDegats($degats) {
        $this->vie -= $degats;
        if ($this->vie < 0) $this->vie = 0;
    }

    public function afficherEtat() {
       echo "<p><strong>$this->nom</strong></p>";
    $this->afficherBarreVie();
    echo "<p>Force : $this->force</p>";
    echo ($this->vie > 0)
        ? "<p style='color:green;'>$this->nom est toujours en vie.</p>"
        : "<p style='color:red;'>$this->nom est hors de combat.</p>";
    }
}

//  Classes enfants
class guerrier extends personnage {
    
    public function subirDegats($degats) {
        $this->vie -= $degats;
        echo " Le guerrier perd $degats points de vie. Il lui reste {$this->vie} PV.<br>";
    }
    private $coupCritiqueUtilise = false;
public function attaquer($adversaire) {
    if ($this->vie <= 0) {
        echo "<p>$this->nom est hors de combat et ne peut pas attaquer.</p>";
        return;
    }

    // Coup critique s'il n'est pas encore utilisé
    if (!$this->coupCritiqueUtilise) {
        $this->coupCritiqueUtilise = true;
        echo "<p><strong style='color:red;'>$this->nom déclenche son COUP CRITIQUE dévastateur ! 💥</strong></p>";
        $adversaire->subirDegats(70);
    } else {
        // Attaque normale
        $degats = $this->force;
        $adversaire->subirDegats($degats);
        echo "<p>$this->nom attaque " . $adversaire->getNom() . " et inflige $degats dégâts.</p>";
    }
}

}

class sangoku extends personnage {
    private $kamehamehaUtilise = false;

    public function subirDegats($degats) {
        $this->vie -= $degats;
        echo " Sangoku encaisse $degats dégâts. Il lui reste {$this->vie} PV.<br>";
    }

    public function attaquer($cible) {
        if ($this->vie <= 0) {
            echo "<p>$this->nom est KO et ne peut plus attaquer.</p>";
            return;
        }

        if (!$this->kamehamehaUtilise) {
            $this->kamehamehaUtilise = true;
            echo "<p><strong style='color:blue;'>$this->nom lance un KAMEHAMEHA surpuissant ! 🌊💥</strong></p>";
            $cible->subirDegats(60);
        } else {
            $degats = $this->force;
            $cible->subirDegats($degats);
            echo "<p>$this->nom attaque avec force normale et inflige $degats dégâts.</p>";
        }
    }
}



class voleur extends personnage {
    public function subirDegats($degats) {
        // 30% de chance d'esquiver
        if (rand(1, 100) <= 30) {
            echo " Le voleur esquive l'attaque avec grâce ! Aucun dégât subi.<br>";
        } else {
            $this->vie -= $degats;
            echo "Le voleur n'a pas esquivé. Il perd $degats PV. Il lui reste {$this->vie} PV.<br>";
        }
    }
}

class magicien extends personnage {
    private function invoquerNecromancie($cible) {
        echo "<p style='color:purple; font-weight:bold;'>🕯️ Le magicien invoque une aura de NÉCROMANCIE... un fantôme surgit ! 👻</p>";
        for ($i = 1; $i <= 5; $i++) {
            echo "<p class='fantome'>👻 Attaque fantôme #$i : 5 dégâts</p>";
            $cible->subirDegats(5);
        }
    }

    public function attaquer($cible) {
        if ($this->vie <= 0) {
            echo "<p>$this->nom est KO et ne peut plus attaquer.</p>";
            return;
        }

        // 🎲 Chance de nécromancie (1 sur 5)
        if (rand(1, 5) === 1) {
            $this->invoquerNecromancie($cible);
            return;
        }

        // ✨ Sinon, attaque classique avec possibilité de coup critique
        $forceAttaque = $this->getForce();
        if (rand(0, 1) === 1) {
            $forceAttaque *= 2;
            echo "<p style='color:blue;'>✨ Coup critique magique ! Force doublée à $forceAttaque</p>";
        } else {
            echo "<p>🔮 Attaque normale avec force de $forceAttaque</p>";
        }

        $cible->subirDegats($forceAttaque);
    }
}








//  Choix du personnage
echo "<h2>Choisissez votre personnage :</h2>";
echo "<form method='post'>";
echo "<select name='personnage'>";
echo "<option value='guerrier'>Guerrier</option>";
echo "<option value='voleur'>Voleur</option>";
echo "<option value='magicien'>Magicien</option>";
echo "<option value='sangoku'>Sangoku</option>";
echo "</select>";
echo "<input type='submit' name='valider_personnage' value='Choisir le personnage'>";
echo "</form>";

//  Traitement du choix
if (isset($_POST['valider_personnage'])) {
    $_SESSION['personnage'] = $_POST['personnage'];
    echo "<p>Personnage choisi : " . $_SESSION['personnage'] . "</p>";
    echo "<form method='post'>";
    echo "<input type='submit' name='combat' value='Lancer le combat'>";
    echo "</form>";
}

//  Combat déclenché
if (isset($_POST['combat']) && isset($_SESSION['personnage'])) {
    // Création du personnage choisi
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
case 'sangoku':
    $personnageChoisi = new sangoku("Sangoku", 120, 25);
    break;

    
    }

if ($_SESSION['personnage'] === 'guerrier') {
    echo "<h2>Alliance entre le voleur et le magicien contre le guerrier !</h2>";
    $guerrier = $personnageChoisi;
    $voleur = new voleur("Voleur", 100, 12);
    $magicien = new magicien("Magicien", 90, 8);

    // Combat en équipe
    while ($guerrier->getVie() > 0 && ($voleur->getVie() > 0 || $magicien->getVie() > 0)) {
        if ($voleur->getVie() > 0) {
            $voleur->attaquer($guerrier);
        }
        if ($guerrier->getVie() > 0 && $voleur->getVie() > 0) {
            $guerrier->attaquer($voleur);
        }

        if ($magicien->getVie() > 0) {
            $magicien->attaquer($guerrier);
        }
        if ($guerrier->getVie() > 0 && $magicien->getVie() > 0) {
            $guerrier->attaquer($magicien);
        }

        $guerrier->afficherEtat();
        $voleur->afficherEtat();
        $magicien->afficherEtat();
    }

    echo "<h3>" . ($guerrier->getVie() > 0 ? "Le guerrier a gagné !" : "Le voleur et le magicien ont triomphé !") . "</h3>";
    session_destroy();
    return;
}

    // Création des adversaires
    $guerrier = new guerrier("Guerrier", 120, 15);
    $voleur = new voleur("Voleur", 100, 12);
    $magicien = new magicien("Magicien", 90, 8);

    $adversaires = array($guerrier, $voleur, $magicien);
    $adversaires = array_filter($adversaires, fn($p) => $p->getNom() !== $personnageChoisi->getNom());
    $adversaireChoisi = $adversaires[array_rand($adversaires)];

    echo "<h2>Combat entre " . $personnageChoisi->getNom() . " et " . $adversaireChoisi->getNom() . "</h2>";

    //  Boucle de combat
    while ($personnageChoisi->getVie() > 0 && $adversaireChoisi->getVie() > 0) {
        $personnageChoisi->attaquer($adversaireChoisi);
        $adversaireChoisi->afficherEtat();
        if ($adversaireChoisi->getVie() > 0) {
            $adversaireChoisi->attaquer($personnageChoisi);
            $personnageChoisi->afficherEtat();
        }
    }

    //  Résultat du combat
    $vainqueur = ($personnageChoisi->getVie() > 0) ? $personnageChoisi : $adversaireChoisi;
    echo "<h3> " . $vainqueur->getNom() . " a gagné le combat !</h3>";

     //  Bilan final
    echo "<h4>État final de " . $personnageChoisi->getNom() . ":</h4>";
    $personnageChoisi->afficherEtat();
    echo "<h4>État final de " . $adversaireChoisi->getNom() . ":</h4>";
    $adversaireChoisi->afficherEtat();

    // Reset session (si besoin )
    session_destroy();
}
?>

</body>
</html>