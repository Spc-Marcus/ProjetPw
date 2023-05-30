<?php
require_once("TrajetDAO.php");
//phpinfo();

$dbFile = '../DB/Donne.db';
$pdo = new PDO('sqlite:' . $dbFile);
$dao=new TrajetDAO();
$dao->setConnect($pdo);
$as=$dao->getAll("Laval");

echo "<table>";
    echo "<tr><th>loc</th></tr>";
    foreach ($as as $a) {
        echo "<tr>";
        echo "<td>" . $a['localisation'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    /*
    $url = "https://nominatim.openstreetmap.org/search?q=Paris&format=json&email=marcusfoin1@gmail.com";
    $curl = curl_init($url);
    $absCertPath = realpath("../Cert/ISRG Root X1.crt");
    curl_setopt($curl, CURLOPT_CAINFO, $absCertPath);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Ajoutez cette option pour récupérer la réponse dans une variable
    
    $data = curl_exec($curl);
    if ($data === false) {
        var_dump(curl_error($curl));
    } else {
        $response = json_decode($data, true); // Ajoutez le deuxième argument `true` pour obtenir un tableau associatif
    
        if (isset($response[0])) { // Vérifiez si l'élément à l'indice 0 existe dans le tableau
            $latitude = $response[0]['lat'];
            $longitude = $response[0]['lon'];
            echo $latitude."<br/>".$longitude;
        } else {
            echo "Aucune donnée de localisation trouvée.";
        }
    }
    
    curl_close($curl);
    */
?>