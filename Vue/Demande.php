<?php include "Template/headerUser.php";

    function genererTableauDemandes($demandes) {
    $tableau = '<table class="table table-striped table-hover">';
    $tableau .= '<thead><th>Nom du festival</th><th>Proposé par</th><th>Demandé par</th><th>Aller</th><th>Retour</th><th colspan="2">action</th></thead><tbody>';

    foreach ($demandes as $demande) {
        $tableau .= '<tr>';
        foreach ($demande as $colonne) {
            // Effectuer des opérations spécifiques en fonction des données de la colonne
            if ($colonne === 1) {
                $valeur = 'Oui';
            } elseif ($colonne === 0) {
                $valeur = 'Non';
            } else {
                $valeur = $colonne;
            }
        
            // Ajouter la cellule au tableau
            $tableau .= '<td>' . $valeur . '</td>';
        }
        $tableau .= '</tr>';
    }

    $tableau .= '</tbody></table>';
    return $tableau;
}
    ?>

