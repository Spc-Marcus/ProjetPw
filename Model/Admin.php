<?php
class Admin {
    private $admin_id;
    private $nom;
    private $prenom;
    private $email;
    private $mot_de_passe;

    public function __construct($nom = null, $prenom = null, $email = null, $mot_de_passe = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
    }
    public function getAdminId() {
        return $this->admin_id;
    }

    public function setAdminId($admin_id) {
        $this->admin_id = $admin_id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getemail() {
        return $this->email;
    }

    public function setemail($email) {
        $this->email = $email;
    }

    public function getMotDePasse() {
        return $this->mot_de_passe;
    }

    public function setMotDePasse($mot_de_passe) {
        $this->mot_de_passe = $mot_de_passe;
    }
}
?>