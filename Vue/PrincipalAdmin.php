<?php include "Template/headerAdmin.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistiques</title>
    <link href="Css/style.css" rel="stylesheet">
    <link href="Css/bootstrap.css" rel="stylesheet">
    <style>
        .card-text {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Statistiques</h1>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre de Trajets</h5>
                        <p class="card-text"><?php
                            $dbFile = '../DB/Donne.db';
                            $pdo = new PDO('sqlite:' . $dbFile);
                            require_once('../DAO/TrajetDAO.php');
                            $trajetDAO = new TrajetDAO($pdo);
                            $trajets = $trajetDAO->getAll();
                            echo count($trajets);
                            ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre de Festivaliers</h5>
                        <p class="card-text"><?php
                            require_once('../DAO/FestivalierDAO.php');
                            $festivalierDAO = new FestivalierDAO($pdo);
                            $festivaliers = $festivalierDAO->getAll();
                            echo count($festivaliers);
                            ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre de Festivals</h5>
                        <p class="card-text"><?php
                            require_once('../DAO/FestivalDAO.php');
                            $festivalDAO = new FestivalDAO($pdo);
                            $festivals = $festivalDAO->getAll();
                            echo count($festivals);
                            ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
