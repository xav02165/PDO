<?php

class humain {
    // Variable
    public $nom;
    public $age;

    // Construct
    public function __construct($nom, $age) {
        $this->nom = $nom;  
        $this->age = $age;
    }   

    // Getter
    public function getNom(){
        return $this->nom;
    }   
    public function getAge(){
        return $this->age;
    }

    // Setter
    public function setNom($nom){
        return $this->nom = $nom;
    }
    public function setAge($age){
        return $this->age = $age;
    }
}
    // Methode

    $femme = new femme("Marie", 25);
    $homme = new homme("Xavier", 47);

class femme extends humain {
    public function __construct ($nom, $age) {
        $this->age = $age;
        $this->nom = $nom;

        echo "<p>Bonjour, je m'appelle " . $this->nom . " et j'ai " . $this->age . " ans.</p>"; 
    }
}
class homme extends humain {
    public function __construct($nom, $age ) {
        $this->age = $age;
        $this->nom = $nom;

        echo "<p>Bonjour, je m'appelle " . $this->nom . " et j'ai " . $this->age . " ans.</p>"; 
}

}

    ?>  
