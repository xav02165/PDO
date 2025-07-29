<?php
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
        
            
        }
    
    public function recevoirDegats($degats) {
            
        }
    public function afficherEtat() {
        echo "<p>Nom: " . $this->nom . "<br>";
        echo "Vie: " . $this->vie . "<br>";     
        echo "Force: " . $this->force . "</p>";


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


