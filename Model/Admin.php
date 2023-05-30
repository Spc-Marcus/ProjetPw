<?php
class Admin {
    private $admin_id;
    private $nom;
    private $prenom;
    private $login;
    private $mot_de_passe;

    public function __construct($nom = null, $prenom = null, $login = null, $mot_de_passe = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
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

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getMotDePasse() {
        return $this->mot_de_passe;
    }

    public function setMotDePasse($mot_de_passe) {
        $this->mot_de_passe = $mot_de_passe;
    }
}
?>