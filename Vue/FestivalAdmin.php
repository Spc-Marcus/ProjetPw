<?php include("Template/headerAdmin.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Festival Admin</title>
    <link href="Css/bootstrap.css" rel="stylesheet">
    <link href="Css/style.css" rel="stylesheet">

</head>

<body>
    <div id="notification-toast" class="toast floating-toast bg-warning text-light" role="alert" aria-live="assertive"
        aria-atomic="true" data-bs-autohide="false">
        <div class="toast-header">
            <strong class="me-auto">Attention</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Veuillez remplir tous les champs avant de sauvegarder.
        </div>
    </div>
    <div class="container">
        <h1>Tableau des festivals</h1>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Date de debut</th>
                    <th>Date de fin</th>
                    <th>Localisation</th>
                    <th>Lien photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once("../DAO/FestivalDAO.php");
                require_once("../Model/Festival.php");
                $dbFile = '../DB/Donne.db';
                $pdo = new PDO('sqlite:' . $dbFile);
                $dao = new FestivalDAO($pdo);
                $festivals = $dao->getAll();
                foreach ($festivals as $festival) {
                    echo "<tr>";
                    echo "<td>" . $festival->getFestivalId() . "</td>";
                    echo "<td class='editable text'>" . $festival->getNom() . "</td>";
                    echo "<td class='editable date'>" . $festival->getDate_debut() . "</td>";
                    echo "<td class='editable date'>" . $festival->getDate_fin() . "</td>";
                    echo "<td class='editable text'>" . $festival->getLocalisation() . "</td>";
                    echo "<td class='editable text'>" . $festival->getPhoto() . "</td>";
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
        <div class="text-center mt-4">
            <button id="add-festival-button" class="btn btn-primary">Ajouter un festival</button><br>
            <br><button id="upload-button"  class="btn btn-primary">Importer une image</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        var uploadButton = document.getElementById('upload-button');

        uploadButton.addEventListener('click', function () {
            var fileInput = document.createElement('input');
            fileInput.type = 'file';

            fileInput.addEventListener('change', function () {
                var file = fileInput.files[0];
                var imageType = /^image\//;

                if (imageType.test(file.type)) {
                    var formData = new FormData();
                    formData.append('image', file, file.name);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../Controleur/upload.php'); // Replace 'upload.php' with the server-side script to handle the upload

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                console.log('Image uploaded successfully!');
                            } else {
                                console.log('Image upload failed.');
                            }
                        }
                    };

                    xhr.send(formData);
                }
            });

            fileInput.click();
        });


        $(document).ready(function () {
            $('.edit-button').on('click', function () {
                var row = $(this).closest('tr');

                var rowData = row.find('.editable');

                var rowtext = row.find('.text')
                var rowDate = row.find('.date')
                rowtext.each(function () {
                    var content = $(this).text();
                    $(this).html('<input type="text" class="form-control" value="' + content + '">');
                    $(this).find('input').data('original-value', content); // Enregistrer la valeur d'origine dans l'attribut de données

                });
                rowDate.each(function () {
                    var content = $(this).text();
                    $(this).html('<input type="date" class="form-control" value="' + content + '">');
                    $(this).find('input').data('original-value', content); // Enregistrer la valeur d'origine dans l'attribut de données

                });
                row.addClass('edit-mode');
                $(this).hide();
                row.find('.delete-button').hide();
                row.find('.actions').toggle();
            });

            $(document).on('click', '.cancel-button', function () {
                var row = $(this).closest('tr');
                Id = row.find('td:first').text();
                if (Id.trim() === '') row.remove();
                else {
                    var rowData = row.find('.editable');
                    rowData.each(function () {
                        var originalValue = $(this).find('input').data('original-value'); // Récupérer la valeur d'origine à partir de l'attribut de données
                        $(this).html(originalValue);
                    });
                    row.removeClass('edit-mode');
                    row.find('.edit-button').show();
                    row.find('.delete-button').show();
                    row.find('.actions').toggle();
                }
            });



            $(document).on('click', '.save-button', function () {
                var row = $(this).closest('tr');
                var rowData = row.find('.editable');
                var isComplete = true;
                var Id, Nom, Date_debut, Date_fin, Localisation, Photo;

                // Obtenir la valeur de la colonne ID (colonne 0)
                Id = row.find('td:first').text();

                // Parcourir les autres colonnes éditables
                rowData.each(function (index) {
                    var input = $(this).find('input');
                    var content = input.val();
                    if (content.trim() === '') {
                        isComplete = false;
                        input.addClass('incomplete');
                    } else {
                        input.removeClass('incomplete');
                        //console.log(content);
                        if (index === 0) {
                            Nom = content;
                        } else if (index === 1) {
                            Date_debut = content;
                        } else if (index === 2) {
                            Date_fin = content;
                        } else if (index === 3) {
                            Localisation = content;
                        } else if (index === 4) {
                            Photo = content;
                        }
                    }
                });
                if (isComplete) {
                    var Action = ""
                    if (Id.trim() === '') {
                        // La variable id est vide
                        Action = "ajouter"
                    } else {
                        // La variable id n'est pas vide
                        Action = "modifier"
                    }

                    $.ajax({
                        url: "../Controleur/modif.php",
                        type: "POST",
                        contentType: "application/x-www-form-urlencoded",
                        data: {
                            action: Action,
                            id: Id,
                            nom: Nom,
                            date_debut: Date_debut,
                            date_fin: Date_fin,
                            localisation: Localisation,
                            photo: Photo,
                            origine: "Festival"

                        },

                        success: function (response) {
                            rowData.each(function () {
                                var content = $(this).find('input').val();
                                $(this).html(content);
                            });
                            row.removeClass('edit-mode');
                            row.find('.edit-button').show();
                            row.find('.delete-button').show();
                            row.find('.btn-info').show();
                            row.find('.actions').toggle();
                            if (Action === 'ajouter') {
                                //modifie la valeur de la 1ere colone par message.id 
                                var idColumn = row.find('td:first');

                                idColumn.text(response.id);

                            }
                        },
                        error: function (response) {
                            console.log('erreur ' + response.message);
                        },
                        complete: function (response) {
                            console.log("Complete");
                        }
                    });


                } else {
                    var toast = new bootstrap.Toast($('#notification-toast')[0]);
                    toast.show();
                }
            });


            $(document).on('click', '.delete-button', function () {
                var row = $(this).closest('tr');
                var ID = row.find('td:first').text();

                $.ajax({
                    url: "../Controleur/modif.php",
                    contentType: "application/x-www-form-urlencoded",
                    type: "POST",
                    data: {
                        action: "supprimer",
                        id: ID,
                        origine: "Festival"
                    },
                    success: function (response) {
                        // Supprimer la ligne si nécessaire
                        row.remove();
                    },
                    error: function (response) {
                        console.log("erreur");
                    },
                    complete: function (response) {
                        console.log("Complete");
                    }
                });
            });



                $('#add-festival-button').on('click', function() {
                    var newRow = $('<tr></tr>');
                    newRow.addClass('edit-mode');
                    newRow.append('<td></td>');
                    newRow.append('<td class="editable text"><input class="form-control" type="text"></td>');
                    newRow.append('<td class="editable date"><input class="form-control" type="date"></td>');
                    newRow.append('<td class="editable date"><input class="form-control" type="date"></td>');
                    newRow.append('<td class="editable text"><input class="form-control" type="text"></td>');
                    newRow.append('<td class="editable text"><input class="form-control" type="text"></td>');
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