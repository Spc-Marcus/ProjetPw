<?php
require_once("../Model/Admin.php");
require_once("../Model/Festivalier.php");
require_once("../DAO/AdminDAO.php");
require_once("../DAO/FestivalierDAO.php");

function getAllUserIds() {
    // Création de la connexion à la base de données
    $dbFile = '../DB/Donne.db';
    $db = new PDO('sqlite:' . $dbFile);
    
    // Création des objets DAO
    $adminDAO = new AdminDAO($db);
    $festivalierDAO = new FestivalierDAO($db);
    
    // Récupération de tous les administrateurs
    $admins = $adminDAO->getAll();
    
    // Récupération de tous les festivaliers
    $festivaliers = $festivalierDAO->getAll();
    
    // Création d'un tableau pour stocker les identifiants
    $userIds = array();
    
    // Parcours des administrateurs et ajout de leurs identifiants au tableau
    foreach ($admins as $admin) {
        $userIds[] = $admin->getAdminId();
    }
    
    // Parcours des festivaliers et ajout de leurs identifiants au tableau
    foreach ($festivaliers as $festivalier) {
        $userIds[] = $festivalier->getID();
    }
    $db=null;
    // Retour du tableau d'identifiants
    return $userIds;
}
?>
