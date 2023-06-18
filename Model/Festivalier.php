<?php
class Festivalier {
    private $ID;
    private $Prenom;
    private $Nom;
    private $Email;
    private $Pwd;
    

    // Constructeur avec tous les paramètres
    public function __construct( $Prenom = null, $Nom = null, $Email = null, $Pwd = null) {
        $this->Prenom = $Prenom;
        $this->Nom = $Nom;
        $this->Email = $Email;
        $this->Pwd = $Pwd;
    }
    
    

    // Getter pour ID
    public function getID() {
        return $this->ID;
    }
    
    // Setter pour ID
    public function setID($ID) {
        $this->ID = $ID;
    }
    
    // Getter pour Prenom
    public function getPrenom() {
        return $this->Prenom;
    }
    
    // Setter pour Prenom
    public function setPrenom($Prenom) {
        $this->Prenom = $Prenom;
    }
    
    // Getter pour Nom
    public function getNom() {
        return $this->Nom;
    }
    
    // Setter pour Nom
    public function setNom($Nom) {
        $this->Nom = $Nom;
    }
    
    // Getter pour Email
    public function getEmail() {
        return $this->Email;
    }
    
    // Setter pour Email
    public function setEmail($Email) {
        $this->Email = $Email;
    }

    // Getter pour Pwd
    public function getPwd() {
        return $this->Pwd;
    }
    
    // Setter pour Pwd
    public function setPwd($Pwd) {
        $this->Pwd = $Pwd;
    }

    
    public function validEmail(){
        return strpos($this->Email, '@') !== false;
    }
}
?>