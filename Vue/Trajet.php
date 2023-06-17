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
        require_once("../DAO/TrajetDAO.php");
        require_once("../Model/Trajet.php");
        
        $dbFile = '../DB/Donne.db';
        $pdo = new PDO('sqlite:' . $dbFile);
        $trajetDAO = new TrajetDAO($pdo);
        $trajets = $trajetDAO->getAll();
        
        $festivalierDAO = new FestivalierDAO($pdo);
        $festivalDAO = new FestivalDAO($pdo);
        
        // Récupération de la liste des festivals
        $festivals = $festivalDAO->getAll();
        
        // Affichage du sélecteur de festivals
        echo '<label for="festival">Sélectionnez un festival :</label>';
        echo '<select id="festival" name="festival" onchange="filterTrajets()" class="form-select">';
        echo '<option value="0">Tous les festivals</option>'; // Option pour afficher tous les trajets
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
    
    <!-- Affichage du tableau des trajets avec les informations du festival et du festivalier -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nom du festival</th>
                <th>Nom et prénom de l'utilisateur</th>
                <th>Type de véhicule</th>
                <th>Nombre de places restantes</th>
                <th>Date d'aller</th>
                <th>Date de retour</th>
                <th>Localisation de départ</th>
                <th>Distance</th> <!-- Nouvelle colonne pour afficher la distance -->
            </tr>
    </thead>
            <tbody>
            <?php
            foreach ($trajets as $trajet) {
                $festivalId = $trajet->getFestivalId();
                $festivalierId = $trajet->getUserId();
                
                $festival = $festivalDAO->getById($festivalId);
                $festivalier = $festivalierDAO->getById($festivalierId);
                
                echo '<tr class="trajet-row" data-festival-id="' . $festivalId . '">';
                echo '<td>' . $festival->getNom() . '</td>';
                echo '<td>' . $festivalier->getNom() . ' ' . $festivalier->getPrenom() . '</td>';
                echo '<td>' . $trajet->getTypeVehicule() . '</td>';
                echo '<td>' . $trajet->getPlacesDisponibles() . '</td>';
                echo '<td>' . $trajet->getDateAller() . '</td>';
                echo '<td>' . $trajet->getDateRetour() . '</td>';
                echo '<td>' . $trajet->getLocalisation() . '</td>';
                echo '<td class="distance-cell"></td>'; // Nouvelle cellule pour afficher la distance
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function filterTrajets() {
        var festivalId = document.getElementById('festival').value;
        var trajets = document.getElementsByClassName('trajet-row');

        // Afficher ou masquer les trajets en fonction du festival sélectionné
        for (var i = 0; i < trajets.length; i++) {
            var trajet = trajets[i];
            var trajetFestivalId = trajet.getAttribute('data-festival-id');

            if (festivalId == 0 || festivalId == trajetFestivalId) {
                trajet.style.display = 'table-row';
            } else {
                trajet.style.display = 'none';
            }
        }
    }
        $(document).ready(function() {
    // Fonction pour construire les données des trajets
    function buildTrajetsData() {
        var trajetsData = [];

        // Parcourir chaque ligne du tableau
        $('.trajet-row').each(function() {
        var festivalId = $(this).data('festival-id');
        var festivalNom = $(this).find('td:nth-child(1)').text();
        var festivalierNomPrenom = $(this).find('td:nth-child(2)').text();
        var typeVehicule = $(this).find('td:nth-child(3)').text();
        var placesDisponibles = $(this).find('td:nth-child(4)').text();
        var dateAller = $(this).find('td:nth-child(5)').text();
        var dateRetour = $(this).find('td:nth-child(6)').text();
        var localisation = $(this).find('td:nth-child(7)').text();

        // Créer un objet trajet avec les données
        var trajet = {
            festivalId: festivalId,
            festivalNom: festivalNom,
            festivalierNomPrenom: festivalierNomPrenom,
            typeVehicule: typeVehicule,
            placesDisponibles: placesDisponibles,
            dateAller: dateAller,
            dateRetour: dateRetour,
            localisation: localisation
        };

        // Ajouter l'objet trajet aux données des trajets
        trajetsData.push(trajet);
        });

        return trajetsData;
    }

    // Soumission du formulaire de recherche
    $('#search-form').submit(function(e) {
        e.preventDefault(); // Empêcher le rechargement de la page

        var adresse = $('#adresse').val();
        var trajetsData = buildTrajetsData();

        // Requête Ajax vers trieDistance.php
        $.ajax({
        url: '../Controleur/trieDistance.php',
        type: 'POST',
        data: {
            trajetsData: trajetsData,
            adresse: adresse
        },
        success: function(response) {
            // Traitement de la réponse
            var datas = response.trajets;

            // Reconstruction de la table avec les données triées
            var tableBody = $('.table tbody');
            tableBody.empty(); // Vider le contenu actuel de la table

            // Parcourir les données triées
            for (var i = 0; i < datas.length; i++) {
            var trajet = datas[i];

            // Créer une nouvelle ligne de tableau
            var row = $('<tr>');
            row.addClass('trajet-row');
            row.attr('data-festival-id', trajet.festivalId);

            // Ajouter les cellules à la ligne
            row.append('<td>' + trajet.festivalNom + '</td>');
            row.append('<td>' + trajet.festivalierNomPrenom + '</td>');
            row.append('<td>' + trajet.typeVehicule + '</td>');
            row.append('<td>' + trajet.placesDisponibles + '</td>');
            row.append('<td>' + trajet.dateAller + '</td>');
            row.append('<td>' + trajet.dateRetour + '</td>');
            row.append('<td>' + trajet.localisation + '</td>');
            row.append('<td>' + trajet.distance + 'km</td>');

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
