<?php
require_once("../Model/Festivalier.php");
/**
 * Classe FestivalierDAO
 * 
 * Cette classe gère les opérations de manipulation des objets Festivalier dans la base de données.
 */
class FestivalierDAO {
    protected $connect;
    
    /**
     * Constructeur de la classe.
     * 
     * @param PDO $db Connexion à la base de données.
     */
    public function __construct($db) {
        $this->connect = $db;
    }
    
    /**
     * Setter pour la connexion à la base de données.
     * 
     * @param PDO $c Connexion à la base de données.
     */
    public function setConnect($c) {
        $this->connect = $c;
    }
    
    /**
     * Getter pour la connexion à la base de données.
     * 
     * @return PDO Connexion à la base de données.
     */
    public function getConnect($c) {
        return $this->connect;
    }
    
    /**
     * Crée un nouveau festivalier dans la base de données.
     * 
     * @param Festivalier $festivalier Objet Festivalier à insérer.
     * @return Festivalier|null Objet Festivalier inséré avec l'ID mis à jour, ou null en cas d'échec.
     */
    public function create(Festivalier $festivalier) {
        // Préparer la requête SQL
        $query = "INSERT INTO Festivalier (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)";
        $stmt = $this->connect->prepare($query);
    
        // Liage des valeurs des paramètres
        $stmt->bindValue(':nom', $festivalier->getNom());
        $stmt->bindValue(':prenom', $festivalier->getPrenom());
        $stmt->bindValue(':email', $festivalier->getEmail());
        $stmt->bindValue(':mot_de_passe', $festivalier->getPwd());
    
        // Exécution de la requête
        $stmt->execute();
        
        // Mise à jour de l'ID généré automatiquement
        $festivalier->setID($this->connect->lastInsertId());
        
        // Retourner l'objet Festivalier avec l'ID mis à jour
        return $festivalier;
    }

    /**
     * Met à jour les informations d'un festivalier dans la base de données.
     * 
     * @param Festivalier $festivalier Objet Festivalier à mettre à jour.
     */
    public function update(Festivalier $festivalier) {
        // Préparer la requête SQL
        $query = "UPDATE Festivalier SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe WHERE user_id = :user_id";
        $stmt = $this->connect->prepare($query);
    
        // Liage des valeurs des paramètres
        $stmt->bindValue(':nom', $festivalier->getNom());
        $stmt->bindValue(':prenom', $festivalier->getPrenom());
        $stmt->bindValue(':email', $festivalier->getEmail());
        $stmt->bindValue(':mot_de_passe', $festivalier->getPwd());
        $stmt->bindValue(':user_id', $festivalier->getID());
    
        // Exécution de la requête
        $stmt->execute();
    }

    /**
     * Supprime un festivalier de la base de données en utilisant son ID.
     * 
     * @param int $user_id ID du festivalier à supprimer.
     */
    public function delete($user_id) {
        // Préparer la requête SQL
        $query = "DELETE FROM Festivalier WHERE user_id = :user_id";
        $stmt = $this->connect->prepare($query);
    
        // Liage de la valeur du paramètre
        $stmt->bindValue(':user_id', $user_id);
    
        // Exécution de la requête
        $stmt->execute();
    }

    /**
     * Récupère un festivalier de la base de données en utilisant son ID.
     * 
     * @param int $user_id ID du festivalier à récupérer.
     * @return Festivalier|null Objet Festivalier récupéré, ou null si aucun festivalier correspondant n'est trouvé.
     */
    public function getById($user_id) {
        // Préparer la requête SQL
        $query = "SELECT * FROM Festivalier WHERE user_id = :user_id";
        $stmt = $this->connect->prepare($query);
    
        // Liage de la valeur du paramètre
        $stmt->bindValue(':user_id', $user_id);
    
        // Exécution de la requête
        $stmt->execute();
        
        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Vérifier si un festivalier a été trouvé
        if ($result) {
            // Créer et retourner l'objet Festivalier correspondant
            return new Festivalier(
                $result['user_id'],
                $result['prenom'],
                $result['nom'],
                $result['email'],
                $result['mot_de_passe']
            );
        } else {
            // Aucun festivalier correspondant trouvé, retourner null
            return null;
        }
    }

    /**
     * Vérifie si un festivalie existe dans la base de données en utilisant le email et le mot de passe.
     * @param $festivalier L'objet festivalier contenant le email et le mot de passe à vérifier
     * @return festivalier|null festivalier complet si l'festivalie existe, sinon null
     */
    public function exist(Festivalier &$festivalier) {
        $query = "SELECT * FROM Festivalier WHERE email = :email AND mot_de_passe = :mot_de_passe";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':email', $festivalier->getemail());
        $stmt->bindValue(':mot_de_passe', $festivalier->getPwd());
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $festivalier->setId($result['user_id']);
            $festivalier->setNom($result['nom']);
            $festivalier->setPrenom($result['prenom']);
            return $festivalier;
        }
        return null;
    }


    /**
     * Récupère tous les festivaliers de la base de données.
     * 
     * @return array Tableau d'objets Festivalier contenant tous les festivaliers.
     */
    public function getAll() {
        // Préparer la requête SQL
        $query = "SELECT * FROM Festivalier";
        $stmt = $this->connect->prepare($query);
    
        // Exécution de la requête
        $stmt->execute();
        
        // Récupération des résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Créer un tableau pour stocker les festivaliers
        $festivaliers = array();
        
        // Parcourir les résultats et créer les objets Festivalier correspondants
        foreach ($results as $result) {
            $festivalier = new Festivalier(
                $result['user_id'],
                $result['prenom'],
                $result['nom'],
                $result['email'],
                $result['mot_de_passe']
            );
            
            // Ajouter le festivalier au tableau
            $festivaliers[] = $festivalier;
        }
        
        // Retourner le tableau de festivaliers
        return $festivaliers;
    }
}

?>
