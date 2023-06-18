<?php include "Template/headerUser.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Informations de l'utilisateur</title>
    <link href="Css/style.css" rel="stylesheet">
    <link href="Css/bootstrap.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        
        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
        }

        .list-group-item {
            font-size: 16px;
            padding: 10px 0;
            border: none;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Informations de l'utilisateur</h1>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Nom:</strong> <?php echo $_SESSION['utilisateur']->getNom(); ?>
            </li>
            <li class="list-group-item">
                <strong>Prénom:</strong> <?php echo $_SESSION['utilisateur']->getPrenom(); ?>
            </li>
            <li class="list-group-item">
                <strong>Adresse e-mail:</strong> <?php echo $_SESSION['utilisateur']->getEmail(); ?>
            </li>
        </ul>
    </div>
</body>
</html>
