<?php
class Presence {
    private $id;
    private $user_id;
    private $festival_id;
    private $date_aller;
    private $date_retour;
    private $aller;
    private $retour;
    private $localisation;

    public function __construct($user_id = null, $festival_id = null, $date_aller = null, $date_retour = null, $aller = null, $retour = null,$loc=null) {

        $this->user_id = $user_id;
        $this->festival_id = $festival_id;
        $this->date_aller = $date_aller;
        $this->date_retour = $date_retour;
        $this->aller = $aller;
        $this->retour = $retour;
        $this->localisation=$loc;
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    // Getters et setters
    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getFestivalId() {
        return $this->festival_id;
    }

    public function setFestivalId($festival_id) {
        $this->festival_id = $festival_id;
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

    public function getAller() {
        return $this->aller;
    }

    public function setAller($aller) {
        $this->aller = $aller;
    }

    public function getRetour() {
        return $this->retour;
    }

    public function setRetour($retour) {
        $this->retour = $retour;
    }

    public function getLocalisation() {
        return $this->localisation;
    }

    public function setLocalisation($localisation) {
        $this->localisation = $localisation;
    }
}

?>