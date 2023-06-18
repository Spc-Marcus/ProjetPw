<?php
require_once("../Outils/Distance.php");
require_once("../Model/Trajet.php");
/**
 * Classe TrajetDAO
 * 
 * Cette classe gère les opérations de manipulation des objets Trajet dans la base de données.
 */
class TrajetDAO
{
    protected $connect;
    public function __construct($db)
    {
        $this->connect = $db;
    }
    public function setConnect($c)
    {
        $this->connect = $c;
    }
    public function getConnect($c)
    {
        return $this->connect;
    }
    /**
     * Summary of create
     * @param Trajet $trajet trajet a ajouter dans la table (!) Id mis a jour au moment de l'ajout
     * @return Trajet trajet avec une id valide dans la table
     */
    public function create(Trajet &$trajet)
    {
        // Préparer la requête SQL
        $query = "  INSERT INTO Trajet (user_id, festival_id, type_vehicule, places_disponibles, date_aller, date_retour, localisation)
                    VALUES (:user_id, :festival_id, :type_vehicule, :places_disponibles, :date_aller, :date_retour, :localisation)";
        $stmt = $this->connect->prepare($query);

        // Liage des valeurs des paramètres
        $stmt->bindValue(':user_id', $trajet->getUserId());
        $stmt->bindValue(':festival_id', $trajet->getFestivalId());
        $stmt->bindValue(':type_vehicule', $trajet->getTypeVehicule());
        $stmt->bindValue(':places_disponibles', $trajet->getPlacesDisponibles());
        $stmt->bindValue(':date_aller', $trajet->getDateAller());
        $stmt->bindValue(':date_retour', $trajet->getDateRetour() ?: null);
        $stmt->bindValue(':localisation', $trajet->getLocalisation());

        // Exécution de la requête
        $stmt->execute();

        // Mise à jour de l'ID généré automatiquement
        $trajet->setTrajetId($this->connect->lastInsertId());
        // Retourner l'objet Trajet sans mettre à jour l'ID
        return $trajet;
    }

    /**
     * Summary of update
     * @param Trajet $trajet Trajet a mettre à jour avec un id valide
     */
    public function update(Trajet $trajet)
    {
        // Préparer la requête SQL
        $retour = $trajet->getDateRetour();
        if (isset($retour)) {
            $query = "UPDATE Trajet
                    SET user_id = :user_id,
                        festival_id = :festival_id,
                        type_vehicule = :type_vehicule,
                        places_disponibles = :places_disponibles,
                        date_aller = :date_aller,
                        date_retour = :date_retour,
                        localisation = :localisation
                    WHERE trajet_id = :trajet_id";
        } else {
            $query = "UPDATE Trajet
                    SET user_id = :user_id,
                        festival_id = :festival_id,
                        type_vehicule = :type_vehicule,
                        places_disponibles = :places_disponibles,
                        date_aller = :date_aller,
                        localisation = :localisation
                    WHERE trajet_id = :trajet_id";
        }
        $stmt = $this->connect->prepare($query);
        if (isset($retour))
            $stmt->bindValue(':date_retour', $trajet->getDateRetour() ?: null);
        // Liage des valeurs des paramètres
        $stmt->bindValue(':user_id', $trajet->getUserId());
        $stmt->bindValue(':festval_id', $trajet->getFestivalId());
        $stmt->bindValue(':type_vehicule', $trajet->getTypeVehicule());
        $stmt->bindValue(':places_disponibles', $trajet->getPlacesDisponibles());
        $stmt->bindValue(':date_aller', $trajet->getDateAller());
        $stmt->bindValue(':trajet_id', $trajet->getTrajetId());

        // Exécution de la requête
        $stmt->execute();
        //var_dump($stmt);
    }


    /**
     * Summary of delete
     * @param  $trajet_id id a delete 
     */
    public function delete($trajet_id)
    {
        $query = "DELETE FROM Trajet WHERE trajet_id = :Id";
        $stmt = $this->connect->prepare($query);

        // Utilisez bindValue pour lier le paramètre :Id à la valeur $trajet_id
        $stmt->bindValue(":Id", $trajet_id, PDO::PARAM_INT);

        // Exécutez la requête
        $stmt->execute();
    }



    /**
     * Summary of getById
     * @param int $trajet_id id a trouver
     * @return Trajet un trajet de la base de données en utilisant son ID
     */
    public function getById(int $trajet_id)
    {
        $query = "SELECT * FROM Trajet WHERE trajet_id= :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindValue(":id", $trajet_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new Trajet(
                $result['user_id'],
                $result['festival_id'],
                $result['type_vehicule'],
                $result['places_disponibles'],
                $result['date_aller'],
                $result['date_retour'],
                $result['localisation']
            );
        } else {
            return new Trajet();
        }
    }

    /**
     * Summary of getAll
     * @param string $loc une localisation
     * @param string $date une date  
     * @param int $fesId Id du festival
     * @return array Array de trajet trier par distance si loc sinon non trier
     */
    public function getAll(string $loc = null, $date = null, int $fesId = null)
    {
        $query = "SELECT * FROM Trajet";

        // Vérifier si des filtres ont été spécifiés
        if ($date || $fesId) {
            $query .= " WHERE";
            $conditions = array();

            if ($date) {
                $conditions[] = "date_aller = :date";
            }

            if ($fesId) {
                $conditions[] = "festival_id = :festival_id";
            }

            // Combinez les conditions avec des opérateurs logiques
            $query .= " " . implode(" AND ", $conditions);
        }

        // Préparer la requête SQL
        $stmt = $this->connect->prepare($query);

        // Liage des valeurs des paramètres si nécessaire
        if ($date) {
            $stmt->bindValue(':date', $date);
        }

        if ($fesId) {
            $stmt->bindValue(':festival_id', $fesId);
        }

        // Exécution de la requête
        $stmt->execute();

        // Récupération des résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Tableau de trajets
        $trajets = array();

        // Parcourir les résultats et créer les objets Trajet
        foreach ($results as $result) {
            $trajet = new Trajet(
                $result['user_id'],
                $result['festival_id'],
                $result['type_vehicule'],
                $result['places_disponibles'],
                $result['date_aller'],
                $result['date_retour'],
                $result['localisation']
            );
            $trajet->setTrajetId($result['trajet_id']);
            // Ajouter le trajet au tableau
            $trajets[] = $trajet;
        }

        // Vérifier si une adresse de recherche est spécifiée
        if ($loc) {
            // Récupérer les coordonnées GPS de l'adresse de recherche
            $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($loc) . "&format=json&email=marcusfoin2@gmail.com";
            $curl = curl_init($url);
            $absCertPath = realpath("../Certificat/ISRG Root X1.crt");
            curl_setopt($curl, CURLOPT_CAINFO, $absCertPath);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response, true); // Ajoutez le deuxième argument `true` pour obtenir un tableau associatif

            if (!empty($data)) {

                $latitude = $data[0]['lat'];
                $longitude = $data[0]['lon'];

                // Calculer la distance entre l'adresse de recherche et chaque annonce
                foreach ($trajets as &$trajet) {

                    $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($trajet->getLocalisation()) . "&format=json&email=marcusfoin2@gmail.com";
                    $resCurl = curl_init($url);
                    curl_setopt($resCurl, CURLOPT_CAINFO, $absCertPath);
                    curl_setopt($resCurl, CURLOPT_RETURNTRANSFER, true); // Ajoutez cette option pour récupérer la réponse dans une variable
                    $resResponse = curl_exec($resCurl);
                    curl_close($resCurl);
                    $resData = json_decode($resResponse, true); // Ajoutez le deuxième argument `true` pour obtenir un tableau associatif

                    if (!empty($resData)) {
                        $resLatitude = $resData[0]['lat'];
                        $resLongitude = $resData[0]['lon'];
                        $distance = distance($latitude, $longitude, $resLatitude, $resLongitude);
                        $trajet->setDistance($distance);
                    }
                }

                // Trier les résultats par ordre croissant de distance
                usort($trajets, function ($a, $b) {
                    return $a->getDistance() - $b->getDistance();
                });
            };
        }

        // Retourner les résultats
        return $trajets;
    }
}

?>