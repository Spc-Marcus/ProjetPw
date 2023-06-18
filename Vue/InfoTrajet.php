<?php include "Template/headerUser.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Info Trajet</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        
        .card-title {
            font-size: 32px;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .card-body {
            font-size: 20px;
        }

        .card-text {
            margin-bottom: 10px;
        }
        .hidden {
            display: none;
        }
    </style>
    <script>
        function verif(){
            var allerCheckbox = document.getElementById("aller");
            var retourCheckbox = document.getElementById("retour");
            var submitBtn = document.getElementById("submitBtn");
            
            if(!allerCheckbox.checked&&!retourCheckbox.checked){
                submitBtn.disabled=true;
            }
            else{
                submitBtn.removeAttribute("disabled");
            }
        }

        function showDemandeForm() {
            var demandeForm = document.getElementById("demandeForm");
            var demandeBtn = document.getElementById("demandeBtn");

            demandeForm.classList.remove("hidden");
            demandeBtn.classList.add("hidden");
        }
    </script>
</head>
<body>
    <?php
    require_once("../DAO/FestivalierDAO.php");
    require_once("../DAO/FestivalDAO.php");
    require_once("../DAO/TrajetDAO.php");
    require_once("../Model/Trajet.php");
    
    $dbFile = '../DB/Donne.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    $trajetDAO = new TrajetDAO($pdo);    
    $festivalierDAO = new FestivalierDAO($pdo);
    $festivalDAO = new FestivalDAO($pdo);

    if(isset($_POST['trajetId'])){
        $trajetId = $_POST['trajetId'];
        $trajet = $trajetDAO->getById($trajetId);
        $festivalId = $trajet->getFestivalId();
        $festivalierId = $trajet->getUserId();
        $festival = $festivalDAO->getById($festivalId);
        $festivalier = $festivalierDAO->getById($festivalierId);

        if($trajet){
            echo '<div class="container">';
            echo '<div class="card mt-5">';
            echo '<h1 class="card-title text-center">Informations sur le trajet</h1>';
            echo '<div class="card-body">';
            echo '<p class="card-text"><strong>Nom du festival :</strong> ' . $festival->getNom() . '</p>';
            echo '<p class="card-text"><strong>Nom et prénom de l\'utilisateur :</strong> ' . $festivalier->getNom() .', '.$festivalier->getPrenom() .'</p>';
            echo '<p class="card-text"><strong>Type de véhicule :</strong> ' . $trajet->getTypeVehicule() . '</p>';
            echo '<p class="card-text"><strong>Nombre de places :</strong> ' . $trajet->getPlacesDisponibles() . '</p>';
            echo '<p class="card-text"><strong>Date d\'aller :</strong> ' . $trajet->getDateAller() . '</p>';
            $retour = $trajet->getDateRetour();
            if($retour!=='') echo '<p class="card-text"><strong>Date de retour :</strong> ' . $trajet->getDateRetour() . '</p>';
            echo '<p class="card-text"><strong>Localisation de départ :</strong> ' . $trajet->getLocalisation() . '</p>';
            echo '</div>';

            if (isset($_SESSION['utilisateur'])) {
                echo '<div class="text-center">';
                echo '<a class="btn btn-primary" href="mailto:' . $festivalier->getEmail() . '">Contact</a>';

                echo '<button id="demandeBtn" class="btn btn-primary" onclick="showDemandeForm()">Créer une demande</button>';

                echo '<form id="demandeForm" action="../Controleur/CreerDemande.php" method="post" class="hidden">';
                echo '<input type="hidden" name="trajetId" value="' . $trajetId . '">';
                echo '<input type="hidden" name="userId" value="' . $_SESSION['utilisateur']->getId() . '">';

                echo '<label for="aller">Aller :</label>';
                echo '<input type="checkbox" id="aller" name="aller" onchange="verif()">';

                if ($retour !== '') {
                    echo '<label for="retour">Retour :</label>';
                    echo '<input type="checkbox" id="retour" name="retour" onchange="verif()">';
                } else {
                    echo '<label for="retour">Retour :</label>';
                    echo '<input type="checkbox" id="retour" name="retour" disabled>';
                }

                echo '<button type="submit" class="btn btn-primary" id="submitBtn" disabled>Demander</button>';
                echo '</form>';

                echo '</div>';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
</body>
</html>
