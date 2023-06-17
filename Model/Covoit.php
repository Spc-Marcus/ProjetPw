<?php
class Covoit {
    private $covoit_id;
    private $accepter;
    private $trajet_id;
    private $user_id;
    private $aller;
    private $retour;

    public function __construct($accepter = null, $trajet_id = null, $user_id = null, $aller = null, $retour = null) {
        $this->accepter = $accepter;
        $this->trajet_id = $trajet_id;
        $this->user_id = $user_id;
        $this->aller = $aller;
        $this->retour = $retour;
    }

    

    // Getters et setters
    public function setCovoitId($covoit_id) {
        $this->covoit_id = $covoit_id;
    }
    public function getCovoitId() {
        return $this->covoit_id;
    }

    public function setAccepter($accepter) {
        $this->accepter = $accepter;
    }

    public function getAccepter() {
        return $this->accepter;
    }

    public function setTrajetId($trajet_id) {
        $this->trajet_id = $trajet_id;
    }

    public function getTrajetId() {
        return $this->trajet_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setAller($aller) {
        $this->aller = $aller;
    }

    public function getAller() {
        return $this->aller;
    }

    public function setRetour($retour) {
        $this->retour = $retour;
    }

    public function getRetour() {
        return $this->retour;
    }
}

?>