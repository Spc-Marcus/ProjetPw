<?php
require_once("../Outils/Distance.php");
const HTTP_OK = 200;
const HTTP_BAD_REQUEST = 400;
const HTTP_METHOD_NOT_ALLOWED = 405;
const HTTP_NO_CONTENT = 204;
if ($_SERVER['REQUEST_METHOD'] === "POST"){
    //var_dump($_POST['Donnes']);
    if(isset($_POST['Donnes'])&&isset($_POST['adresse'])){
        $Donnes=$_POST['Donnes'];
        $adresse=$_POST['adresse'];
        // Récupérer les coordonnées GPS de l'adresse de recherche
        $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($adresse) . "&format=json&email=marcusfoin2@gmail.com";
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
            foreach ($Donnes as &$Donne) {

                $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($Donne['localisation']) . "&format=json&email=marcusfoin2@gmail.com";
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
                    $Donne['distance']=round($distance);
                }else {
                    retourTrie(HTTP_NO_CONTENT,"L'une des adresse de Donne donner ne renvoie pas de coordonner par l'Api");
                }
            }
            usort($Donnes, function ($a, $b) {
                return $a['distance'] - $b['distance'];
            });
            retourTrie(HTTP_OK,"Trie effectué avec succes",$Donnes);
        }
        else{
            retourTrie(HTTP_NO_CONTENT,"L'adresse donner ne renvoie pas de coordonner par l'Api");
        }
    }
    else{
        retourTrie(HTTP_BAD_REQUEST,"Valeurs manquantes dans la requete");
    }
}else{
    retourTrie(HTTP_METHOD_NOT_ALLOWED, "Méthode non autorisée");
}



function retourTrie($code, $message,$Donnes=null) {
    http_response_code($code);
    header("Content-Type: application/json");
    echo json_encode(array("message" => $message,"Donnes"=>$Donnes));
    exit;
}
?>