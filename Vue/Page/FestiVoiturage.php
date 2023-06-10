<!DOCTYPE html>
<html>
<head>
    <title>Tableau Bootstrap avec style</title>
    <link href="../Css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Tableau avec style Bootstrap</h1>
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
                <tr>
                    <td>1</td>
                    <td>Foin</td>
                    <td>Marcus</td>
                    <td>marcusfoin1@gmail.com</td>
                    <td>toto</td>
                    <td>
                        <form action="InfoAdmin.php" method="post">
                            <input type="hidden" name="id" value="1">
                            <button type="submit" class="btn btn-info">+ d'info</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-primary edit-button">Modifier</button>
                        <button class="btn btn-danger delete-button">Supprimer</button>
                        <div class="actions" style="display: none;">
                            <button class="btn btn-success save-button">Sauvegarder</button>
                            <button class="btn btn-warning cancel-button">Annuler</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Baudy</td>
                    <td>Simon</td>
                    <td>SimonBaudy@gmail.com</td>
                    <td>titi</td>
                    <td>
                        <form action="InfoAdmin.php" method="post">
                            <input type="hidden" name="id" value="2">
                            <button type="submit" class="btn btn-info">+ d'info</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-primary edit-button">Modifier</button>
                        <button class="btn btn-danger delete-button">Supprimer</button>
                        <div class="actions" style="display: none;">
                            <button class="btn btn-success save-button">Sauvegarder</button>
                            <button class="btn btn-warning cancel-button">Annuler</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Thomas</td>
                    <td>Rousseau</td>
                    <td>Rousseau@gmail.com</td>
                    <td>tiai</td>
                    <td>
                        <form action="InfoAdmin.php" method="post">
                            <input type="hidden" name="id" value="3">
                            <button type="submit" class="btn btn-info">+ d'info</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-primary edit-button">Modifier</button>
                        <button class="btn btn-danger delete-button">Supprimer</button>
                        <div class="actions" style="display: none;">
                            <button class="btn btn-success save-button">Sauvegarder</button>
                            <button class="btn btn-warning cancel-button">Annuler</button>
                        </div>
                    </td>
                </tr>
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
