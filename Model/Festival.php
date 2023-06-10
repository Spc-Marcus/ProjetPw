<?php
class Festival {
    private $festival_id;
    private $nom;
    private $date_debut;

    private $date_fin;
    private $localisation;
    private $photo;

    public function __construct($nom = null, $date_debut = null, $date_fin =null, $localisation = null, $photo = null) {
        $this->nom = $nom;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->localisation = $localisation;
        $this->photo = $photo;
    }
    public function getFestivalId() {
        return $this->festival_id;
    }

    public function setFestivalId($festival_id) {
        $this->festival_id = $festival_id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getDate_debut() {
        return $this->date_debut;
    }

    public function setDate_debut($date) {
        $this->date_debut = $date;
    }

    public function getDate_fin() {
        return $this->date_fin;
    }

    public function setDate_fin($date) {
        $this->date_fin = $date;
    }
    public function getLocalisation() {
        return $this->localisation;
    }

    public function setLocalisation($localisation) {
        $this->localisation = $localisation;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

}

?>