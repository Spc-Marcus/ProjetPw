<?php
class Festival {
    private $festival_id;
    private $nom;
    private $dates;
    private $localisation;
    private $photo;

    public function __construct($nom = null, $dates = null, $localisation = null, $photo = null) {
        $this->nom = $nom;
        $this->dates = $dates;
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

    public function getDates() {
        return $this->dates;
    }

    public function setDates($dates) {
        $this->dates = $dates;
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