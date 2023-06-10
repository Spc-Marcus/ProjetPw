<?php include("Template/headerAdmin.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau Bootstrap avec style</title>
    <link href="Css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 255, 0.1); /* Couleur de fond transparente pour les lignes impaires */
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: rgba(0, 0, 255, 0.2); /* Couleur de fond transparente pour les lignes paires */
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 0, 0, 0.3); /* Couleur de fond transparente pour le survol des lignes */
        }

        .edit-mode input {
            border: 1px solid #000;
            background-color: #5f5ff5;
        }

        .edit-mode .actions {
            display: flex;
            align-items: center;
        }

        .edit-mode .save-button,
        .edit-mode .cancel-button {
            margin-left: 5px;
        }
        h1 {
            text-align: center;
            border-top : 2px solid #5f5ff5;
            border-bottom: 2px solid #5f5ff5;
            padding: 10px 0;
        }
        h1:first-child{
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">

        <h1 >Tableau des admins</h1>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Mot de passe</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once("../DAO/AdminDAO.php");   
                require_once("../Model/Admin.php");
                $dbFile = '../DB/Donne.db';
                $pdo = new PDO('sqlite:' . $dbFile);
                $dao= new AdminDAO($pdo);
                $admins = $dao->getAll();
                foreach ($admins as $admin) {
                    echo "<tr>";
                    echo "<td>".$admin->getAdminId()."</td>";
                    echo "<td>".$admin->getNom()."</td>";
                    echo "<td>".$admin->getPrenom()."</td>";
                    echo "<td>".$admin->getEmail()."</td>";
                    echo "<td>".$admin->getMotDePasse()."</td>";
                    echo"<td>
                    <form action='InfoAdmin.php' method='post'>
                        <input type='hidden' name='id' value='".$admin->getAdminId()."'>
                        <button type='submit' class='btn btn-info'>+ d'info</button>
                    </form>
                </td>
                <td>
                    <button class='btn btn-primary edit-button'>Modifier</button>
                    <button class='btn btn-danger delete-button'>Supprimer</button>
                    <div class='actions' style='display: none;'>
                        <button class='btn btn-success save-button'>Sauvegarder</button>
                        <button class='btn btn-warning cancel-button'>Annuler</button>
                    </div>
                </td>";
                    echo "</tr>";
                }
                $pdo=null;
                ?>
                
            </tbody>
        </table>
    </div>

    <div class="container">
        <h1 >Tableau des festivaliers</h1>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Mot de passe</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once("../DAO/FestivalierDAO.php");   
                require_once("../Model/Festivalier.php");
                $dbFile = '../DB/Donne.db';
                $pdo = new PDO('sqlite:' . $dbFile);
                $dao= new FestivalierDAO($pdo);
                $festivaliers = $dao->getAll();
                foreach ($festivaliers as $festivalier) {
                    echo "<tr>";
                    echo "<td>".$festivalier->getId()."</td>";
                    echo "<td>".$festivalier->getNom()."</td>";
                    echo "<td>".$festivalier->getPrenom()."</td>";
                    echo "<td>".$festivalier->getEmail()."</td>";
                    echo "<td>".$festivalier->getPwd()."</td>";
                    echo"<td>
                    <form action='InfoAdmin.php' method='post'>
                        <input type='hidden' name='id' value='".$festivalier->getId()."'>
                        <button type='submit' class='btn btn-info'>+ d'info</button>
                    </form>
                </td>
                <td>
                    <button class='btn btn-primary edit-button'>Modifier</button>
                    <button class='btn btn-danger delete-button'>Supprimer</button>
                    <div class='actions' style='display: none;'>
                        <button class='btn btn-success save-button'>Sauvegarder</button>
                        <button class='btn btn-warning cancel-button'>Annuler</button>
                    </div>
                </td>";
                    echo "</tr>";
                }
                $pdo=null;
                ?>
                
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
            $(document).ready(function() {
                $('.edit-button').on('click', function() {
                    var row = $(this).closest('tr');
                    var rowData = row.find('td:not(:first-child):not(:nth-last-child(2)):not(:last-child)');
                        rowData.each(function() {
                        var content = $(this).text();
                        $(this).html('<input type="text" value="' + content + '">');
                    });
                    row.addClass('edit-mode');
                    $(this).hide();
                    row.find('.delete-button').hide();
                    row.find('.actions').toggle();
                });

            $(document).on('click', '.cancel-button', function() {
                var row = $(this).closest('tr');
                var rowData = row.find('td:not(:first-child):not(:nth-last-child(2)):not(:last-child)');
                rowData.each(function() {
                    var content = $(this).find('input').val();
                    $(this).html(content);
                });
                row.removeClass('edit-mode');
                row.find('.edit-button').show();
                row.find('.delete-button').show();
                row.find('.actions').toggle();
            });

            $(document).on('click', '.save-button', function() {
                var row = $(this).closest('tr');
                var rowData = row.find('td:not(:first-child):not(:nth-last-child(2)):not(:last-child)');
                rowData.each(function() {
                    var content = $(this).find('input').val();
                    $(this).html(content);
                });
                row.removeClass('edit-mode');
                row.find('.edit-button').show();
                row.find('.delete-button').show();
                row.find('.actions').toggle();
            });

            $(document).on('click', '.delete-button', function() {
                var row = $(this).closest('tr');
                row.remove();
            });
        });
    </script>
</body>
</html>
