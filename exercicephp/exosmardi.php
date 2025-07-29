<?php

class chien {
    // Variable
    private $nom;
    private $race;

    // Construct
    public function __construct($nom, $race) {
        $this->nom = $nom;  
        $this->race = $race;
    }   


    // Getter
    public function getNom(){
        return $this->nom;
    }   
    public function getRace(){
        return $this->race;
    }

    // Setter
    public function setNom($nom){
        return $this->nom = $nom;
    }
    public function setRace($race){
        return $this->race = $race;
    }

    

//Methode
public function aboyer(){
        echo "<p>Woof je suis " . $this->nom . "<p>";
    }
}




?>


