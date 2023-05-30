<?php
class Trajet {
    private $trajet_id;
    private $user_id;
    private $type_vehicule;
    private $places_disponibles;
    private $date_aller;
    private $date_retour;
    private $localisation;

    public function __construct($user_id = null, $type_vehicule = null, $places_disponibles = null, $date_aller = null, $date_retour = null,$localisation =null) {
        $this->user_id = $user_id;
        $this->type_vehicule = $type_vehicule;
        $this->places_disponibles = $places_disponibles;
        $this->date_aller = $date_aller;
        $this->date_retour = $date_retour;
        $this->localisation=$localisation;
    }
    public function getTrajetId() {
        return $this->trajet_id;
    }

    public function setTrajetId($trajet_id) {
        $this->trajet_id = $trajet_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getTypeVehicule() {
        return $this->type_vehicule;
    }

    public function setTypeVehicule($type_vehicule) {
        $this->type_vehicule = $type_vehicule;
    }

    public function getPlacesDisponibles() {
        return $this->places_disponibles;
    }

    public function setPlacesDisponibles($places_disponibles) {
        $this->places_disponibles = $places_disponibles;
    }

    public function getDateAller() {
        return $this->date_aller;
    }

    public function setDateAller($date_aller) {
        $this->date_aller = $date_aller;
    }

    public function getDateRetour() {
        return $this->date_retour;
    }

    public function setDateRetour($date_retour) {
        $this->date_retour = $date_retour;
    }
    public function getLocalisation() {
        return $this->localisation;
    }

    public function setLocalisation($localisation) {
        $this->localisation = $localisation;
    }
}

?>