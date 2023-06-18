<?php include "Template/headerUser.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Info recherche</title>
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
    require_once("../DAO/PresenceDAO.php");
    require_once("../Model/Presence.php");
    
    $dbFile = '../DB/Donne.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    $presenceDAO = new PresenceDAO($pdo);    
    $festivalierDAO = new FestivalierDAO($pdo);
    $festivalDAO = new FestivalDAO($pdo);

    if(isset($_POST['PresenceId'])){
        $presenceId = $_POST['PresenceId'];
        $presence = $presenceDAO->getById($presenceId);
        $festivalId = $presence->getFestivalId();
        $festivalierId = $presence->getUserId();
        $festival = $festivalDAO->getById($festivalId);
        $festivalier = $festivalierDAO->getById($festivalierId);

        if($presence){
            echo '<div class="container">';
            echo '<div class="card mt-5">';
            echo '<h1 class="card-title text-center">Informations sur la recherche</h1>';
            echo '<div class="card-body">';
            echo '<p class="card-text"><strong>Nom du festival :</strong> ' . $festival->getNom() . '</p>';
            echo '<p class="card-text"><strong>Nom et prénom de l\'utilisateur :</strong> ' . $festivalier->getNom() .', '.$festivalier->getPrenom() .'</p>';
            echo '<p class="card-text"><strong>Type de véhicule :</strong> ' . $presence->getDateAller() . '</p>';
            echo '<p class="card-text"><strong>Nombre de places :</strong> ' . $presence->getDateRetour() . '</p>';
            echo '<p class="card-text"><strong>Date d\'aller :</strong> ' . $presence->getAller() . '</p>';
            echo '<p class="card-text"><strong>Date de retour :</strong> ' . $presence->getRetour() . '</p>';
            echo '<p class="card-text"><strong>Localisation de départ :</strong> ' . $presence->getLocalisation() . '</p>';
            echo '</div>';

            if (isset($_SESSION['utilisateur'])) {
                echo '<div class="text-center">';
                echo '<a class="btn btn-primary" href="mailto:' . $festivalier->getEmail() . '">Contact</a>';
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
