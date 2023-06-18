<?php include("Template/headerAdmin.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Utilisateur Admin</title>
    <link href="Css/style.css" rel="stylesheet">
    <link href="Css/bootstrap.css" rel="stylesheet">
    

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

        <h1 >Tableau des admins</h1>
        <table class="table table-striped table-hover" id="Admin">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Mot de passe</th>
                    <th>Actions</th>
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
                    echo "<td class='editable'>".$admin->getNom()."</td>";
                    echo "<td class='editable'>".$admin->getPrenom()."</td>";
                    echo "<td class='editable'>".$admin->getEmail()."</td>";
                    echo "<td class='editable'>".$admin->getMotDePasse()."</td>";
                    echo"<td>
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
        <div class="text-center mt-4">
            <button id="add-admin-button" class="btn btn-primary">Ajouter un admin</button>
        </div>
    </div>

    <div class="container">
        <h1 >Tableau des festivaliers</h1>
        <table class="table table-striped table-hover" id="Festivalier">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Mot de passe</th>
                    <th>Actions</th>
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
                    echo "<td  class='editable'>".$festivalier->getNom()."</td>";
                    echo "<td class='editable'>".$festivalier->getPrenom()."</td>";
                    echo "<td class='editable'>".$festivalier->getEmail()."</td>";
                    echo "<td class='editable'>".$festivalier->getPwd()."</td>";
                    echo"<td>
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
        <div class="text-center mt-4">
            <button id="add-festivalier-button" class="btn btn-primary">Ajouter un festivalier</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
            $(document).ready(function() {
                $('.edit-button').on('click', function() {
        var row = $(this).closest('tr');
        var rowData = row.find('.editable');
        rowData.each(function() {
            var content = $(this).text();
            $(this).html('<input class="form-control" type="text" value="' + content + '">');
            $(this).find('input').data('original-value', content); // Enregistrer la valeur d'origine dans l'attribut de données
        });
        row.addClass('edit-mode');
        $(this).hide();
        row.find('.delete-button').hide();
        row.find('.btn-info').hide();
        row.find('.actions').toggle();
    });

    $(document).on('click', '.cancel-button', function() {
        var row = $(this).closest('tr');
        Id = row.find('td:first').text();
        if(Id.trim()==='')row.remove();
        
        else{
        var rowData = row.find('.editable');
        rowData.each(function() {
            var originalValue = $(this).find('input').data('original-value'); // Récupérer la valeur d'origine à partir de l'attribut de données
            $(this).html(originalValue);
        });
        row.removeClass('edit-mode');
        row.find('.edit-button').show();
        row.find('.delete-button').show();
        row.find('.btn-info').show();
        row.find('.actions').toggle();}
    });


    $(document).on('click', '.save-button', function() {
        var row = $(this).closest('tr');
        var rowData = row.find('.editable');
        var isComplete = true;
        var ID,Nom,Prenom,Email,Mdp;
        Id = row.find('td:first').text();
        var Origine = $(this).closest('table').attr('id');


        rowData.each(function(index) {
            var input = $(this).find('input');
            var content = input.val();
            if (content.trim() === '') {
                isComplete = false;
                input.addClass('incomplete');
            } else {
                input.removeClass('incomplete');
                    if (index === 0) {
                        Nom = content;
                    } else if (index === 1) {
                        Prenom = content;
                    } else if (index === 2) {
                        Email = content;
                    } else if (index === 3) {
                        Mdp = content;
                    }
            }
        });

        if (isComplete) {

            var Action=""
                    if (Id.trim() === '') {
                        // La variable id est vide
                        Action="ajouter"
                    } else {
                        // La variable id n'est pas vide
                        Action="modifier"
                    }


            $.ajax({
                    url: "../Controleur/modif.php",
                    type: "POST",
                    contentType: "application/x-www-form-urlencoded",
                    data: {
                        action: Action,
                        id:Id,
                        nom:Nom,
                        prenom:Prenom,
                        email:Email,
                        mdp:Mdp,
                        origine: Origine

                    },

                    success: function(response) {
                        rowData.each(function() {
                        var content = $(this).find('input').val();
                        $(this).html(content);
                            });
                            row.removeClass('edit-mode');
                            row.find('.edit-button').show();
                            row.find('.delete-button').show();
                            row.find('.btn-info').show();
                            row.find('.actions').toggle();
                            if(Action==='ajouter') {
                            //modifie la valeur de la 1ere colone par message.id 
                            var idColumn = row.find('td:first');
                            
                            idColumn.text(response.id);

                            }
                            },
                    error: function(response) {
                        console.log('erreur '+response.message);
                    },
                    complete: function(response) {
                        console.log("Complete");
                    }
                });

                
            } else {
                var toast = new bootstrap.Toast($('#notification-toast')[0]);
                toast.show();
            }
        });



            $(document).on('click', '.delete-button', function() {
                var row = $(this).closest('tr');
                var ID = row.find('td:first').text();
                var Origine = $(this).closest('table').attr('id');

                $.ajax({
                    url: "../Controleur/modif.php",
                    contentType: "application/x-www-form-urlencoded",
                    type: "POST",
                    data: {
                        action: "supprimer",
                        id: ID,
                        origine: Origine
                    },
                    success: function(response) {
                        // Supprimer la ligne si nécessaire
                        row.remove();
                    },
                    error: function(response) {
                        console.log("erreur");
                    },
                    complete: function(response) {
                        console.log("Complete");
                    }
                });
            });

            
            $('#add-admin-button').on('click', function() {
                    var newRow = $('<tr></tr>');
                    newRow.addClass('edit-mode');
                    newRow.append('<td></td>');
                    newRow.append('<td class="editable"><input class="form-control" type="text"></td>');
                    newRow.append('<td class="editable"><input class="form-control" type="text"></td>');
                    newRow.append('<td class="editable"><input class="form-control" type="text"></td>');
                    newRow.append('<td class="editable"><input class="form-control" type="text"></td>');
                    newRow.append("<td colspan='2'><button class='btn btn-primary edit-button'>Modifier</button><button class='btn btn-danger delete-button'>Supprimer</button><div class='actions' style='display: none;'>                                <button class='btn btn-success save-button'>Sauvegarder</button>                                <button class='btn btn-warning cancel-button'>Annuler</button>                            </div></td>");                    

                    // Afficher les boutons "Sauvegarder" et "Annuler" et masquer les boutons "Modifier" et "Supprimer"
                    newRow.find('.save-button, .cancel-button').show();
                    newRow.find('.edit-button, .delete-button').hide();
                    newRow.find('.actions').toggle();
                    $('#Admin tbody').append(newRow);
        });
        $('#add-festivalier-button').on('click', function() {
                    var newRow = $('<tr></tr>');
                    newRow.addClass('edit-mode');
                    newRow.append('<td></td>');
                    newRow.append('<td class="editable"><input class="form-control" type="text"></td>');
                    newRow.append('<td class="editable"><input class="form-control" type="text"></td>');
                    newRow.append('<td class="editable"><input class="form-control" type="text"></td>');
                    newRow.append('<td class="editable"><input class="form-control" type="text"></td>');
                    newRow.append("<td colspan='2'><button class='btn btn-primary edit-button'>Modifier</button><button class='btn btn-danger delete-button'>Supprimer</button><div class='actions' style='display: none;'>                                <button class='btn btn-success save-button'>Sauvegarder</button>                                <button class='btn btn-warning cancel-button'>Annuler</button>                            </div></td>");                    

                    // Afficher les boutons "Sauvegarder" et "Annuler" et masquer les boutons "Modifier" et "Supprimer"
                    newRow.find('.save-button, .cancel-button').show();
                    newRow.find('.edit-button, .delete-button').hide();
                    newRow.find('.actions').toggle();
                    $('#Festivalier tbody').append(newRow);
        });

        
        });
    </script>
</body>
</html>
