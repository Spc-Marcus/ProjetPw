<?php
require_once ("../Model/Covoit.php");

/**
 * Classe CovoitDAO
 * 
 * Cette classe gère l'accès aux données des objets Covoit dans la base de données.
 */
class CovoitDAO {
    protected $connect;
    /**
     * Constructeur de la classe CovoitDAO.
     * 
     * @param PDO $db Une instance de la classe PDO représentant la connexion à la base de données.
     */
    public function __construct($db) {
        $this->connect = $db;
    }

    /**
     * Crée un nouvel enregistrement de Covoit dans la base de données.
     * 
     * @param Covoit $covoit L'objet Covoit à créer.
     * @return Covoit L'objet Covoit avec l'identifiant généré.
     */
    public function create(Covoit &$covoit) {
        $query = "INSERT INTO Covoit (accepter, trajet_id, user_id, aller, retour) 
                    VALUES (:accepter, :trajet_id, :user_id, :aller, :retour)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':accepter', $covoit->getAccepter());
        $stmt->bindValue(':trajet_id', $covoit->getTrajetId());
        $stmt->bindValue(':user_id', $covoit->getUserId());
        $stmt->bindValue(':aller', $covoit->getAller());
        $stmt->bindValue(':retour', $covoit->getRetour());
        $stmt->execute();
        $covoit->setCovoitId($this->connect->lastInsertId());
        return $covoit;
    }

    /**
     * Met à jour les informations d'un enregistrement de Covoit dans la base de données.
     * 
     * @param Covoit $covoit L'objet Covoit à mettre à jour.
     */
    public function update(Covoit $covoit) {
        $query = "UPDATE Covoit SET accepter = :accepter, trajet_id = :trajet_id, 
                    user_id = :user_id, aller = :aller, retour = :retour 
                    WHERE covoit_id = :covoit_id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':accepter', $covoit->getAccepter());
        $stmt->bindValue(':trajet_id', $covoit->getTrajetId());
        $stmt->bindValue(':user_id', $covoit->getUserId());
        $stmt->bindValue(':aller', $covoit->getAller());
        $stmt->bindValue(':retour', $covoit->getRetour());
        $stmt->bindValue(':covoit_id', $covoit->getCovoitId());
        $stmt->execute();
    }

    /**
     * Supprime un enregistrement de Covoit de la base de données en utilisant son identifiant.
     * 
     * @param int $covoit_id L'identifiant de l'enregistrement de Covoit à supprimer.
     */
    public function delete(int $covoit_id) {
        $query = "DELETE FROM Covoit WHERE covoit_id = :covoit_id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':covoit_id', $covoit_id);
        $stmt->execute();
    }

    /**
     * Récupère un enregistrement de Covoit de la base de données en utilisant son identifiant.
     * 
     * @param int $covoit_id L'identifiant de l'enregistrement de Covoit à récupérer.
     * @return Covoit|null L'objet Covoit correspondant à l'identifiant spécifié, ou null si aucun enregistrement n'est trouvé.
     */
    public function getById(int $covoit_id ) {
        $query = "SELECT * FROM Covoit WHERE covoit_id = :covoit_id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':covoit_id', $covoit_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $covoit = new Covoit();
            $covoit->setCovoitId($result['covoit_id']);
            $covoit->setAccepter($result['accepter']);
            $covoit->setTrajetId($result['trajet_id']);
            $covoit->setUserId($result['user_id']);
            $covoit->setAller($result['aller']);
            $covoit->setRetour($result['retour']);
            return $covoit;
        }
        return null;
    }

    /**
     * Récupère tous les enregistrements de Covoit de la base de données.
     * 
     * @return array Un tableau contenant tous les objets Covoit de la base de données.
     */
    public function getAll() {
        $query = "SELECT * FROM Covoit";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $covoits = [];
        foreach ($results as $result) {
            $covoit = new Covoit();
            $covoit->setCovoitId($result['covoit_id']);
            $covoit->setAccepter($result['accepter']);
            $covoit->setTrajetId($result['trajet_id']);
            $covoit->setUserId($result['user_id']);
            $covoit->setAller($result['aller']);
            $covoit->setRetour($result['retour']);
            $covoits[]=$covoit;
        }
        return $covoits;
    }


    public function getByDemandeurId(int $DemandeurId ) {
        $query = "SELECT * FROM Covoit WHERE user_id = :user_id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':user_id', $DemandeurId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $covoits = [];
        foreach ($results as $result) {
            $covoit = new Covoit();
            $covoit->setCovoitId($result['covoit_id']);
            $covoit->setAccepter($result['accepter']);
            $covoit->setTrajetId($result['trajet_id']);
            $covoit->setUserId($result['user_id']);
            $covoit->setAller($result['aller']);
            $covoit->setRetour($result['retour']);
            $covoits[]=$covoit;
        }
        return $covoits;
    }
    
    public function getByConducteurId(int $ConducteurId ) {
        $query = "SELECT *
        FROM Covoit
        WHERE trajet_id IN (
            SELECT trajet_id
            FROM Trajet
            WHERE user_id = :user_id
        )";
        ;
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':user_id', $ConducteurId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $covoits = [];
        foreach ($results as $result) {
            $covoit = new Covoit();
            $covoit->setCovoitId($result['covoit_id']);
            $covoit->setAccepter($result['accepter']=== "true");
            $covoit->setTrajetId($result['trajet_id']);
            $covoit->setUserId($result['user_id']);
            $covoit->setAller($result['aller']=== "true");
            $covoit->setRetour($result['retour']=== "true");
            $covoits[]=$covoit;
        }
        return $covoits;
    }
}



?>