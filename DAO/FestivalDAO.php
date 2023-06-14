<?php

require_once("../Model/Festival.php");
class FestivalDAO {
    protected $connect;
    
    public function __construct(PDO $connect) {
        $this->connect = $connect;
    }

    /**
     * Insère un nouveau festival dans la base de données.
     * 
     * @param Festival $festival Objet Festival à insérer.
     * @return Festival Festival créé avec l'ID mis à jour
     */
    public function create(Festival &$festival) {
        // Préparer la requête SQL
        $query = "INSERT INTO Festival (nom, date_debut,date_fin, localisation, photo) VALUES (:nom, :date_debut,:date_fin, :localisation, :photo)";
        $stmt = $this->connect->prepare($query);
        
        // Liage des valeurs des paramètres
        $stmt->bindValue(':nom', $festival->getNom());
        $stmt->bindValue(':date_debut', $festival->getDate_debut());
        $stmt->bindValue(':date_fin', $festival->getDate_fin());
        $stmt->bindValue(':localisation', $festival->getLocalisation());
        $stmt->bindValue(':photo', $festival->getPhoto());
        
        // Exécution de la requête
        $stmt->execute();
        $festival->setFestivalId($this->connect->lastInsertId());
        
        return $festival;
    }

    /**
     * Met à jour les informations d'un festival dans la base de données.
     * 
     * @param Festival $festival Objet Festival à mettre à jour.
     */
    public function update(Festival $festival) {
        // Préparer la requête SQL
        $query = "UPDATE Festival SET nom = :nom, date_debut = :date_debut, date_fin = :date_fin, localisation = :localisation, photo = :photo WHERE festival_id = :festival_id";
        $stmt = $this->connect->prepare($query);
        
        // Liage des valeurs des paramètres
        $stmt->bindValue(':festival_id', $festival->getFestivalId());
        $stmt->bindValue(':nom', $festival->getNom());
        $stmt->bindValue(':date_debut', $festival->getDate_debut());
        $stmt->bindValue(':date_fin', $festival->getDate_fin());
        $stmt->bindValue(':localisation', $festival->getLocalisation());
        $stmt->bindValue(':photo', $festival->getPhoto());
        $stmt->execute();
    }

    /**
     * Supprime un festival de la base de données en utilisant son ID.
     * 
     * @param int $festival_id ID du festival à supprimer.
     */
    public function delete($festival_id) {
        // Préparer la requête SQL
        $query = "DELETE FROM Festival WHERE festival_id = :festival_id";
        $stmt = $this->connect->prepare($query);
    
        // Liage de la valeur du paramètre
        $stmt->bindValue(':festival_id', $festival_id);
        $stmt->execute();
    }

    /**
     * Récupère un festival de la base de données en utilisant son ID.
     * 
     * @param int $festival_id ID du festival à récupérer.
     * @return Festival|null Objet Festival récupéré, ou null si aucun festival trouvé.
     */
    public function getById($festival_id) {
        // Préparer la requête SQL
        $query = "SELECT * FROM Festival WHERE festival_id = :festival_id";
        $stmt = $this->connect->prepare($query);
    
        // Liage de la valeur du paramètre
        $stmt->bindValue(':festival_id', $festival_id);
    
        // Exécution de la requête
        $stmt->execute();
    
        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Vérifier si un résultat a été trouvé
        if ($result) {
            // Créer et retourner un objet Festival correspondant
            return new Festival(
                $result['nom'],
                $result['date_debut'],
                $result['date_fin'],
                $result['localisation'],
                $result['photo']
            );
        } else {
            // Aucun festival trouvé, retourner null
            return null;
        }
    }

    /**
     * Récupère tous les festivals de la base de données.
     * 
     * @return array Tableau d'objets Festival.
     */
    public function getAll() {
        // Préparer la requête SQL
        $query = "SELECT * FROM Festival";
        $stmt = $this->connect->prepare($query);
        
        // Exécution de la requête
        $stmt->execute();
        
        // Récupération des résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $festivals = array();
        
        // Parcourir les résultats et créer les objets Festival correspondants
        foreach ($results as $result) {
            $festival = new Festival(
                $result['nom'],
                $result['date_debut'],
                $result['date_fin'],
                $result['localisation'],
                $result['photo']
            );
            
            $festival->setFestivalId($result['festival_id']);
            
            // Ajouter le festival au tableau
            $festivals[] = $festival;
        }
        
        // Retourner le tableau de festivals
        return $festivals;
    }
}

?>
