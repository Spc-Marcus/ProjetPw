<?php include "Template/headerUser.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>titre</title>
</head>
<body>
<div class="container">
    <div class="my-3"> <!-- Espace ajouté avec la classe 'my-3' de Bootstrap -->
        <?php
        require_once("../DAO/FestivalierDAO.php");
        require_once("../DAO/FestivalDAO.php");
        require_once("../DAO/PresenceDAO.php");
        require_once("../Model/Presence.php");
        
        $dbFile = '../DB/Donne.db';
        $pdo = new PDO('sqlite:' . $dbFile);
        $PresenceDAO = new PresenceDAO($pdo);
        $Presences = $PresenceDAO->getAll();
        
        $festivalierDAO = new FestivalierDAO($pdo);
        $festivalDAO = new FestivalDAO($pdo);
        
        // Récupération de la liste des festivals
        $festivals = $festivalDAO->getAll();
        
        // Affichage du sélecteur de festivals
        echo '<label for="festival">Sélectionnez un festival :</label>';
        echo '<select id="festival" name="festival" onchange="filterPresences()" class="form-select">';
        echo '<option value="0">Tous les festivals</option>'; // Option pour afficher tous les Presences
        foreach ($festivals as $festival) {
            echo '<option value="' . $festival->getFestivalId() . '">' . $festival->getNom() . '</option>';
        }
        echo '</select>';
        
        // Formulaire de recherche par adresse
        echo '<form id="search-form" class="mt-3">';
        echo '<div class="mb-3">';
        echo '<label for="adresse">Recherche par adresse :</label>';
        echo '<input type="text" id="adresse" name="adresse" class="form-control">';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Rechercher</button>';
        echo '</form>';
        ?>
    </div>
    
    <!-- Affichage du tableau des Presence avec les informations du festival et du festivalier -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nom du festival</th>
                <th>Nom et prénom de l'utilisateur</th>
                <th>Date d'aller</th>
                <th>Date de retour</th>
                <th>Aller</th>
                <th>Retour</th>                
                <th>Localisation</th>
                <th>Distance</th> 
                <th>Action</th> 
            </tr>
    </thead>
            <tbody>
            <?php
            foreach ($Presences as $Presence) {
                $festivalId = $Presence->getFestivalId();
                $festivalierId = $Presence->getUserId();
                
                $festival = $festivalDAO->getById($festivalId);
                $festivalier = $festivalierDAO->getById($festivalierId);
                
                echo '<tr class="Presence-row" data-festival-id="' . $festivalId . '" data-presence-id="'.$Presence->getId().'">';
                echo '<td>' . $festival->getNom() . '</td>';
                echo '<td>' . $festivalier->getNom() . ' ' . $festivalier->getPrenom() . '</td>';
                echo '<td>' . $Presence->getDateAller() . '</td>';
                echo '<td>' . $Presence->getDateRetour() . '</td>';
                echo '<td>' . $Presence->getAller() . '</td>';
                echo '<td>' . $Presence->getRetour() . '</td>';
                echo '<td>' . $Presence->getLocalisation() . '</td>';
                echo '<td></td>';
                echo '<td>';
                echo '<form action="InfoRecherche.php" method="post">';
                echo '<input type="hidden" name="PresenceId" value="' .$Presence->getId() . '">';
                echo '<button type="submit" class="btn btn-primary">Plus d\'infos</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function filterPresences() {
        var festivalId = document.getElementById('festival').value;
        var Presences = document.getElementsByClassName('Presence-row');

        // Afficher ou masquer les Presences en fonction du festival sélectionné
        for (var i = 0; i < Presences.length; i++) {
            var Presence = Presences[i];
            var PresenceFestivalId = Presence.getAttribute('data-festival-id');

            if (festivalId == 0 || festivalId == PresenceFestivalId) {
                Presence.style.display = 'table-row';
            } else {
                Presence.style.display = 'none';
            }
        }
    }

    $(document).ready(function() {
        // Fonction pour construire les données des Presences
        function buildPresencesData() {
            var PresencesData = [];

            // Parcourir chaque ligne du tableau
            $('.Presence-row').each(function() {
                var festivalId = $(this).data('festival-id');
                var PresenceId=$(this).data('Presence-id');
                var festivalNom = $(this).find('td:nth-child(1)').text();
                var festivalierNomPrenom = $(this).find('td:nth-child(2)').text();
                var dateAller = $(this).find('td:nth-child(3)').text();
                var dateRetour = $(this).find('td:nth-child(4)').text();
                var Aller = $(this).find('td:nth-child(5)').text();
                var Retour = $(this).find('td:nth-child(6)').text();
                var localisation = $(this).find('td:nth-child(7)').text();

                // Créer un objet Presence avec les données
                var Presence = {
                    festivalId: festivalId,
                    festivalNom: festivalNom,
                    festivalierNomPrenom: festivalierNomPrenom,
                    dateAller: dateAller,
                    dateRetour: dateRetour,
                    Aller: Aller,
                    Retour: Retour,
                    localisation: localisation,
                    PresenceId: PresenceId
                };

                // Ajouter l'objet Presence aux données des Presences
                PresencesData.push(Presence);
            });

            return PresencesData;
        }

        // Soumission du formulaire de recherche
        $('#search-form').submit(function(e) {
            e.preventDefault(); // Empêcher le rechargement de la page

            var adresse = $('#adresse').val();
            var PresencesData = buildPresencesData();

            // Requête Ajax vers trieDistance.php
            $.ajax({
                url: '../Controleur/trieDistance.php',
                type: 'POST',
                data: {
                    Donnes: PresencesData,
                    adresse: adresse
                },
                success: function(response) {
                    // Traitement de la réponse
                    var datas = response.Donnes;

                    // Reconstruction de la table avec les données triées
                    var tableBody = $('.table tbody');
                    tableBody.empty(); // Vider le contenu actuel de la table
                    console.log(datas);
                    // Parcourir les données triées
                    for (var i = 0; i < datas.length; i++) {
                        var Presence = datas[i];

                        // Créer une nouvelle ligne de tableau
                        var row = $('<tr>');
                        row.addClass('Presence-row');
                        row.attr('data-festival-id', Presence.festivalId);
                        row.attr('data-Presence-id', Presence.PresenceId);

                        // Ajouter les cellules à la ligne
                        row.append('<td>' + Presence.festivalNom + '</td>');
                        row.append('<td>' + Presence.festivalierNomPrenom + '</td>');
                        row.append('<td>' + Presence.dateAller + '</td>');
                        row.append('<td>' + Presence.dateRetour + '</td>');
                        row.append('<td>' + Presence.Aller + '</td>');
                        row.append('<td>' + Presence.Retour + '</td>');
                        row.append('<td>' + Presence.localisation + '</td>');
                        row.append('<td>' + Presence.distance + 'km </td>');
                        row.append('<td>');
                        row.append('<form action="InfoPresence.php" method="post">');
                        row.append('<input type="hidden" name="PresenceId" value="' + Presence.PresenceId + '">');
                        row.append('<button type="submit" class="btn btn-primary">Plus d\'infos</button>');
                        row.append('</form>');
                        row.append('</td>');

                        // Ajouter la ligne à la table
                        tableBody.append(row);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Une erreur est survenue lors de la requête Ajax : ' + error);
                }
            });
        });

        // Affichage du festival sélectionné
        $('#festival').change(function() {
            var selectedFestival = $(this).find('option:selected').text();
            $('#selected-festival').text(selectedFestival);
        });
    });
</script>
</body>
</html>
