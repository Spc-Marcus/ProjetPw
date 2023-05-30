<?php
require_once("../Controleur/Distance.php");
class TrajetDAO {
    public $courant;
    protected static $connect;
    public function __construct($c=null){
        $this->courant=$c;
    }
    public static function setConnect($c){
        self::$connect = $c;
    }

    public function create(Trajet $trajet) {
        // Code pour insérer un nouveau trajet dans la base de données
    }

    public function update(Trajet $trajet) {
        // Code pour mettre à jour les informations d'un trajet dans la base de données
    }

    public function delete($trajet_id) {
        // Code pour supprimer un trajet de la base de données en utilisant son ID
    }

    public function getById($trajet_id) {
        // Code pour récupérer un trajet de la base de données en utilisant son ID
    }
    public static function getAll($loc = null, $date = null, $fesId = null) {
        $query = "SELECT * FROM Trajet";
        /*
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
        $stmt = self::$connect->prepare($query);
    
        // Liage des valeurs des paramètres si nécessaire
        if ($date) {
            $stmt->bindValue(':date', $date);
        }
    
        if ($fesId) {
            $stmt->bindValue(':festival_id', $fesId);
        }
        */
        // Exécution de la requête
        $stmt = self::$connect->prepare($query);
        $stmt->execute();
    
        // Récupération des résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    
        // Vérifier si une adresse de recherche est spécifiée
        if ($loc) {
            // Récupérer les coordonnées GPS de l'adresse de recherche
            $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($loc) . "&format=json&email=marcusfoin2@gmail.com";
            $curl = curl_init($url);
            $absCertPath = realpath("../Cert/ISRG Root X1.crt");
            curl_setopt($curl, CURLOPT_CAINFO, $absCertPath);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response, true); // Ajoutez le deuxième argument `true` pour obtenir un tableau associatif
            echo"a";
            if (!empty($data)) {
                echo"b";
                $latitude = $data[0]['lat'];
                $longitude = $data[0]['lon'];
                echo $latitude."<br/>".$longitude;
                // Calculer la distance entre l'adresse de recherche et chaque annonce
                foreach ($results as &$result) {
                    $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($result['localisation']) . "&format=json&email=marcusfoin2@gmail.com";
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
                        $result['distance'] = $distance;
                        echo $distance."<br>";
                    }}  
    
                // Trier les résultats par ordre croissant de distance
                usort($results, function ($a, $b) {
                    return $a['distance'] - $b['distance'];
                });
            }{

            }
        }
    
        // Retourner les résultats
        return $results;
    }
    
    
    
}

?>