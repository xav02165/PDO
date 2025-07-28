<?php

class Chat {  

    // Variable
    private $race;
    private $typePoil;
    private $couleurPoils;
    private $couleurYeux;
    private $genre;


    // Construct
    public function __construct($race, $typePoil, $couleurPoils, $couleurYeux, $genre) {
        $this->race = $race;
        $this->typePoil = $typePoil;
        $this->couleurPoils = $couleurPoils;
        $this->couleurYeux = $couleurYeux;
        $this->genre = $genre;
    }

    // Getter
    public function getRace(){
        return $this->race;
    }
    public function getTypePoil(){
        return $this->typePoil;
    }
    public function getCouleurPoils(){
        return $this->couleurPoils;
    }
    public function getCouleurYeux(){
        return $this->couleurYeux;
    }
    public function getGenre(){
        return $this->genre;
    }
    
    // Setter
    public function setRace($race){
        return $this->race = $race;
    }
    public function setTypePoil($typePoil){
        return $this->typePoil = $typePoil;
    }
    public function setCouleurPoils($couleur){
        return $this->couleurPoils = $couleur;
    }
    public function setCouleurYeux($couleur){
        return $this->couleurYeux = $couleur;
    }
    public function setGenre($genre){
        return $this->genre = $genre;
    }
    

    // Methode

    public function test(){
        echo "<p>je fais un test</p>";
    }
}

$chat = new Chat('gouttiere', "court", "blanc", "orange", "femelle");
var_dump($chat);
    


//objet voiture
class Voiture {

    // Variable
    private $marque;
    private $modele;
    private $couleur;
    private $annee;

    // Construct
    public function __construct($marque, $modele, $couleur, $annee) {
        $this->marque = $marque;
        $this->modele = $modele;
        $this->couleur = $couleur;
        $this->annee = $annee;
    }

    // Getter
    public function getMarque(){
        return $this->marque;
    }
    public function getModele(){
        return $this->modele;
    }
    public function getCouleur(){
        return $this->couleur;
    }
    public function getAnnee(){
        return $this->annee;
    }

    // Setter
    public function setMarque($marque){
        return $this->marque = $marque;
    }
    public function setModele($modele){
        return $this->modele = $modele;
    }
    public function setCouleur($couleur){
        return $this->couleur = $couleur;
    }
    public function setAnnee($annee){
        return $this->annee = $annee;
    }
}
$voiture = new Voiture('Toyota', 'Corolla', 'bleu', 2020);
var_dump($voiture);



