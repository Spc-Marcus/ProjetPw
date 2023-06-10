<?php
require_once("../Model/Admin.php");
/**
 * Classe AdminDAO
 * 
 * Cette classe gère les opérations de manipulation des objets Admin dans la base de données.
 */
class AdminDAO {
    protected $connect;

    /**
     * Constructeur de la classe.
     * @param $db L'objet de connexion à la base de données
     */
    public function __construct(PDO $db) {
        $this->connect = $db;
    }

    /**
     * Définit l'objet de connexion à la base de données.
     * @param $c L'objet de connexion à la base de données
     */
    public function setConnect(PDO $c){
        $this->connect = $c;
    }

    /**
     * Récupère l'objet de connexion à la base de données.
     * @return Pdo pdo de connexion à la base de données
     */
    public function getConnect(){
        return $this->connect;
    }

    /**
     * Crée un nouvel administrateur dans la base de données.
     * @param $admin L'objet Admin à insérer
     * @return Admin  Admin créé avec l'ID mis à jour
     */
    public function create(Admin &$admin) {
        $query = "INSERT INTO Admin (nom, prenom, email, mot_de_passe) 
                    VALUES (:nom, :prenom, :email, :mot_de_passe)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':nom', $admin->getNom());
        $stmt->bindValue(':prenom', $admin->getPrenom());
        $stmt->bindValue(':email', $admin->getemail());
        $stmt->bindValue(':mot_de_passe', $admin->getMotDePasse());
        $stmt->execute();
        $admin->setAdminId($this->connect->lastInsertId());
        return $admin;
    }

    /**
     * Met à jour les informations d'un administrateur dans la base de données.
     * @param $admin L'objet Admin à mettre à jour
     */
    public function update(Admin $admin) {
        $query = "UPDATE Admin 
                    SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe 
                    WHERE admin_id = :admin_id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':nom', $admin->getNom());
        $stmt->bindValue(':prenom', $admin->getPrenom());
        $stmt->bindValue(':email', $admin->getemail());
        $stmt->bindValue(':mot_de_passe', $admin->getMotDePasse());
        $stmt->bindValue(':admin_id', $admin->getAdminId());
        $stmt->execute();
    }

    /**
     * Supprime un administrateur de la base de données en utilisant son ID.
     * @param $admin_id L'ID de l'administrateur à supprimer
     */
    public function delete(int $admin_id) {
        $query = "DELETE FROM Admin WHERE admin_id = :admin_id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':admin_id', $admin_id);
        $stmt->execute();
    }

    /**
     * Récupère un administrateur de la base de données en utilisant son ID.
     * @param $admin_id L'ID de l'administrateur à récupérer
     * @return Admin|null Admin correspondant à l'ID, ou null si non trouvé
     */
    public function getById(int $admin_id) {
        $query = "SELECT * FROM Admin WHERE admin_id = :admin_id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':admin_id', $admin_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $admin = new Admin();
        $admin->setAdminId($row['admin_id']);
        $admin->setNom($row['nom']);
        $admin->setPrenom($row['prenom']);
        $admin->setemail($row['email']);
        $admin->setMotDePasse($row['mot_de_passe']);
        return $admin;
    }

    /**
     * Récupère tous les administrateurs de la base de données.
     * @return array tableau d'objets Admin contenant tous les administrateurs
     */
    public function getAll() {
        $query = "SELECT * FROM Admin";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        $admins = array();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $admin = new Admin();
            $admin->setAdminId($result['admin_id']);
            $admin->setNom($result['nom']);
            $admin->setPrenom($result['prenom']);
            $admin->setemail($result['email']);
            $admin->setMotDePasse($result['mot_de_passe']);
            $admins[] = $admin;
        }
        return $admins;
    }

    /**
     * Vérifie si un administrateur existe dans la base de données en utilisant le email et le mot de passe.
     * @param $admin L'objet Admin contenant le email et le mot de passe à vérifier
     * @return Admin|null Admin complet si l'administrateur existe, sinon null
     */
    public function exist(Admin $admin) {
        $query = "SELECT * FROM Admin WHERE email = :email AND mot_de_passe = :mot_de_passe";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(':email', $admin->getemail());
        $stmt->bindValue(':mot_de_passe', $admin->getMotDePasse());
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $admin->setAdminId($result['admin_id']);
            $admin->setNom($result['nom']);
            $admin->setPrenom($result['prenom']);
            return $admin;
        }
        return null;
    }
}

?>