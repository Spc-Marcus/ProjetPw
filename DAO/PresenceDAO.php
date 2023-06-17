<?php

require_once("../Model/Presence.php");
class PresenceDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Crée une nouvelle présence dans la base de données.
     *
     * @param Presence $presence L'objet Presence à insérer.
     */
    public function create(Presence $presence) {
        var_dump($presence);
        $query = "INSERT INTO Presence (user_id, festival_id, date_aller, date_retour, aller, retour) 
                    VALUES (:user_id, :festival_id, :date_aller, :date_retour, :aller, :retour)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $presence->getUserId());
        $stmt->bindValue(':festival_id', $presence->getFestivalId());
        $stmt->bindValue(':date_aller', $presence->getDateAller() ?: null);
        $stmt->bindValue(':date_retour', $presence->getDateRetour() ?: null);
        $stmt->bindValue(':aller', $presence->getAller());
        $stmt->bindValue(':retour', $presence->getRetour());
        $stmt->execute();

    }

    /**
     * Met à jour les informations d'une présence dans la base de données.
     *
     * @param Presence $presence L'objet Presence à mettre à jour.
     */
    public function update(Presence $presence) {
        $query = "UPDATE Presence SET user_id = :user_id ,festival_id = :festival_id, date_aller = :date_aller, date_retour = :date_retour, aller = :aller, retour = :retour WHERE id=:id";
        $stmt = $this->db->prepare($query);
        $stmt -> bindValue(":id",$presence->getId());
        $stmt->bindValue(':date_aller', $presence->getDateAller() ?: null);
        $stmt->bindValue(':date_retour', $presence->getDateRetour()?: null);
        $stmt->bindValue(':aller', $presence->getAller());
        $stmt->bindValue(':retour', $presence->getRetour());
        $stmt->bindValue(':user_id', $presence->getUserId());
        $stmt->bindValue(':festival_id', $presence->getFestivalId());
        $stmt->execute();
    }
    /**
     * Supprime une présence de la base de données en utilisant les identifiants de l'utilisateur et du festival.
     *
     * @param int $user_id L'identifiant de l'utilisateur.
     * @param int $festival_id L'identifiant du festival.
     * @return bool True si la suppression a réussi, false sinon.
     */
    public function delete($id) {
        $query = "DELETE FROM Presence WHERE id = :id ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    /**
     * Récupère toutes les présences d'un utilisateur de la base de données en utilisant son identifiant.
     *
     * @param int $user_id L'identifiant de l'utilisateur.
     * @return array Un tableau d'objets Presence correspondant aux présences de l'utilisateur.
     */
    public function getByUserId($user_id) {
        $query = "SELECT * FROM Presence WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();

        $presences = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $presence = new Presence();
            $presence->setUserId($row['user_id']);
            $presence->setFestivalId($row['festival_id']);
            $presence->setDateAller($row['date_aller']);
            $presence->setDateRetour($row['date_retour']);
            $presence->setAller($row['aller']);
            $presence->setRetour($row['retour']);

            $presences[] = $presence;
        }

        return $presences;
    }

    /**
     * Récupère toutes les présences d'un festival de la base de données en utilisant son identifiant.
     *
     * @param int $festival_id L'identifiant du festival.
     * @return array Un tableau d'objets Presence correspondant aux présences du festival.
     */
    public function getByFestivalId($festival_id) {
        $query = "SELECT * FROM Presence WHERE festival_id = :festival_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':festival_id', $festival_id);
        $stmt->execute();

        $presences = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $presence = new Presence();
            $presence->setUserId($row['user_id']);
            $presence->setFestivalId($row['festival_id']);
            $presence->setDateAller($row['date_aller']);
            $presence->setDateRetour($row['date_retour']);
            $presence->setAller($row['aller']);
            $presence->setRetour($row['retour']);

            $presences[] = $presence;
        }

        return $presences;
    }
    public function getAll(){
        $query="SELECT * FROM Presence";
        $stmt=$this->db->prepare($query);
        $stmt->execute();
        $presences = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $presence = new Presence();
            $presence->setId($row['id']);
            $presence->setUserId($row['user_id']);
            $presence->setFestivalId($row['festival_id']);
            $presence->setDateAller($row['date_aller']);
            $presence->setDateRetour($row['date_retour']);
            $presence->setAller($row['aller']);
            $presence->setRetour($row['retour']);

            $presences[] = $presence;
        }

        return $presences;
    }
}

?>