<?php include "Template/headerUser.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Info Festival</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        
        .card-title {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            font-size: 8vw;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
        }

        .card-body {
            font-size: 20px;
        }

        .card-text {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
    require_once("../DAO/FestivalDAO.php");
    require_once("../Model/Festival.php");

    $dbFile = '../DB/Donne.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    $dao = new FestivalDAO($pdo);

    if(isset($_POST['festival_id'])){
        $festivalId = $_POST['festival_id'];
        $festival = $dao->getById($festivalId);

        if($festival){
            echo '<div class="container">';
            echo '<div class="card mt-5">';
            echo '<img class="card-img-top" src="../Image/'.$festival->getPhoto().'" alt="Image du festival">';
            echo '<h1 class="card-title text-center">'.$festival->getNom().'</h1>';
            echo '<div class="card-body">';
            echo '<p class="card-text"><strong>Date de début:</strong> '.$festival->getDate_debut().'</p>';
            echo '<p class="card-text"><strong>Date de fin:</strong> '.$festival->getDate_fin().'</p>';
            echo '<p class="card-text"><strong>Localisation:</strong> '.$festival->getLocalisation().'</p>';
            echo '<div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" id="Proposition" data-bs-toggle="dropdown" aria-expanded="false"> 
        J\'y    </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="Proposition">
          <li><a class="dropdown-item" href="">Je propose un trajet</a></li>
          <li><a class="dropdown-item" href="">Je recherche un trajet</a></li>
        </ul>
      </div>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }
    }
    ?>

</body>
</html>
