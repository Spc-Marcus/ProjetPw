<?php
// Tableau de données multidimensionnelles
$donnees = [
    ['nom' => 'John Doe', 'age' => 25, 'ville' => 'New York'],
    ['nom' => 'Jane Smith', 'age' => 30, 'ville' => 'London'],
    ['nom' => 'Mike Johnson', 'age' => 35, 'ville' => 'Paris'],
    ['nom' => 'Lisa Brown', 'age' => 28, 'ville' => 'Tokyo']
];

// Récupérer la clé de tri à partir de la requête AJAX
$cleTri = $_POST['cle'];

// Fonction de comparaison personnalisée pour trier le tableau
function comparerDonnees($a, $b) {
    global $cleTri;
    return strnatcmp($a[$cleTri], $b[$cleTri]);
}

// Tri du tableau en utilisant la fonction de comparaison personnalisée
usort($donnees, 'comparerDonnees');

// Renvoyer les données triées au format JSON
header('Content-Type: application/json');
echo json_encode($donnees);
?>
