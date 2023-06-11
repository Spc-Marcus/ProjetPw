<?php include("Template/headerAdmin.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>trajet Admin</title>
    <link href="Css/bootstrap.css" rel="stylesheet">
    <link href="Css/style.css" rel="stylesheet">

</head>
<body>
    <div id="notification-toast" class="toast floating-toast bg-warning text-light" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
        <div class="toast-header">
            <strong class="me-auto">Attention</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Veuillez remplir tous les champs avant de sauvegarder.
        </div>
    </div>
    <div class="container">
        <h1>Tableau des trajets</h1>
        <div class="table-responsive">
        <table class="table table-striped table-hover">

            <thead>
                <tr>
                    <th>id</th>
                    <th>User</th>
                    <th>festival</th>
                    <th>Vehicule</th>
                    <th>Place disponible</th>
                    <th>Date d'aller</th>
                    <th>Date de retour</th>
                    <th>Localisation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once("../DAO/TrajetDAO.php");
                require_once("../Model/Trajet.php");
                $dbFile = '../DB/Donne.db';
                $pdo = new PDO('sqlite:' . $dbFile);
                $dao = new trajetDAO($pdo);
                $trajets = $dao->getAll();
                foreach ($trajets as $trajet) {
                    echo "<tr>";
                    echo "<td>" . $trajet->getTrajetId() . "</td>";
                    echo "<td class='editable number'>" . $trajet->getUserId() . "</td>";
                    echo "<td class='editable number'>" . $trajet->getFestivalId() . "</td>";
                    echo "<td class='editable text'>" . $trajet->getTypeVehicule() . "</td>";
                    echo "<td class='editable number'>" . $trajet->getPlacesDisponibles() . "</td>";
                    echo "<td class='editable date'>" . $trajet->getDateAller() . "</td>";
                    echo "<td class='editable date'>" . $trajet->getDateRetour() . "</td>";
                    echo "<td class='editable text'>" . $trajet->getLocalisation() . "</td>";
                    echo "<td>
                            <button class='btn btn-primary edit-button'>Modifier</button>
                            <button class='btn btn-danger delete-button'>Supprimer</button>
                            <div class='actions' style='display: none;'>
                                <button class='btn btn-success save-button'>Sauvegarder</button>
                                <button class='btn btn-warning cancel-button'>Annuler</button>
                            </div>
                        </td>";
                    echo "</tr>";
                }
                $pdo = null;
                ?>
                
            </tbody>
        </table>
        </div>
        <div class="text-center mt-4">
            <button id="add-trajet-button" class="btn btn-primary">Ajouter un trajet</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit-button').on('click', function() {
                var row = $(this).closest('tr');
                var rowData = row.find('.editable');

                var rowtext=row.find('.text')
                var rowDate=row.find('.date')
                var rowNumber=row.find('.number')
                rowtext.each(function() {
                    var content = $(this).text();
                    $(this).html('<input type="text" value="' + content + '">');
                    $(this).find('input').data('original-value', content); // Enregistrer la valeur d'origine dans l'attribut de données

                });
                rowDate.each(function() {
                    var content = $(this).text();
                    $(this).html('<input type="date" value="' + content + '">');
                    $(this).find('input').data('original-value', content); // Enregistrer la valeur d'origine dans l'attribut de données

                });
                rowNumber.each(function() {
                    var content = $(this).text();
                    $(this).html('<input type="number" value="' + content + '">');
                    $(this).find('input').data('original-value', content); // Enregistrer la valeur d'origine dans l'attribut de données

                });
                row.addClass('edit-mode');
                $(this).hide();
                row.find('.delete-button').hide();
                row.find('.actions').toggle();
            });

            $(document).on('click', '.cancel-button', function() {
                var row = $(this).closest('tr');
                var rowData = row.find('.editable');
                rowData.each(function() {
            var originalValue = $(this).find('input').data('original-value'); // Récupérer la valeur d'origine à partir de l'attribut de données
            $(this).html(originalValue);
                });
                row.removeClass('edit-mode');
                row.find('.edit-button').show();
                row.find('.delete-button').show();
                row.find('.actions').toggle();
            });

            $(document).on('click', '.save-button', function() {
    var row = $(this).closest('tr');
    var rowData = row.find('.editable');
    var isComplete = true;

    rowData.each(function() {
        var input = $(this).find('input');
        var content = input.val();
        if (input.attr('type') !== 'date' && content.trim() === '') {
            isComplete = false;
            input.addClass('incomplete');
        } else {
            input.removeClass('incomplete');
        }
    });

    if (isComplete) {
        rowData.each(function() {
            var input = $(this).find('input');
            var content = input.val();
            if (input.attr('type') === 'date' && content.trim() === '') {
                content = ''; // Définir le contenu comme vide s'il s'agit d'un champ de date et qu'il est vide
            }
            $(this).html(content);
        });
        row.removeClass('edit-mode');
        row.find('.edit-button').show();
        row.find('.delete-button').show();
        row.find('.btn-info').show();
        row.find('.actions').toggle();
    } else {
        var toast = new bootstrap.Toast($('#notification-toast')[0]);
        toast.show();
    }
});


            $(document).on('click', '.delete-button', function() {
                var row = $(this).closest('tr');
                row.remove();
            });

                $('#add-trajet-button').on('click', function() {
                    var newRow = $('<tr></tr>');
                    newRow.addClass('edit-mode');
                    newRow.append('<td></td>');
                    newRow.append('<td class="editable"><input type="number"></td>');
                    newRow.append('<td class="editable"><input type="number"></td>');
                    newRow.append('<td class="editable"><input type="text"></td>');
                    newRow.append('<td class="editable"><input type="number"></td>');
                    newRow.append('<td class="editable"><input type="date"></td>');
                    newRow.append('<td class="editable"><input type="date"></td>');
                    newRow.append('<td class="editable"><input type="text"></td>');
                    newRow.append("<td><button class='btn btn-primary edit-button'>Modifier</button><button class='btn btn-danger delete-button'>Supprimer</button><div class='actions' style='display: none;'>                                <button class='btn btn-success save-button'>Sauvegarder</button>                                <button class='btn btn-warning cancel-button'>Annuler</button>                            </div></td>");                    

                    // Afficher les boutons "Sauvegarder" et "Annuler" et masquer les boutons "Modifier" et "Supprimer"
                    newRow.find('.save-button, .cancel-button').show();
                    newRow.find('.edit-button, .delete-button').hide();
                    newRow.find('.actions').toggle();
                    $('tbody').append(newRow);
        });



        });
    </script>
</body>
</html>
