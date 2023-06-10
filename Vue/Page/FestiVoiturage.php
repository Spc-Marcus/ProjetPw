<!DOCTYPE html>
<html>
<head>
    <title>Tableau avec modification et suppression</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-row:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .edit-menu {
            display: none;
        }

        .edit-menu.active {
            display: flex;
            gap: 5px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Colonne 1</th>
                    <th scope="col">Colonne 2</th>
                    <th scope="col">Colonne 3</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-row">
                    <td contenteditable="false">Donnée 1</td>
                    <td contenteditable="true">Donnée 2</td>
                    <td contenteditable="true">Donnée 3</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                ...
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-item edit-action">Modifier</li>
                                <li class="dropdown-item delete-action">Supprimer</li>
                            </ul>
                        </div>
                        <div class="edit-menu">
                            <button class="btn btn-primary save-action">Enregistrer</button>
                            <button class="btn btn-secondary cancel-action">Annuler</button>
                        </div>
                    </td>
                </tr>
                <tr class="table-row">
                    <td contenteditable="false">Donnée 4</td>
                    <td contenteditable="true">Donnée 5</td>
                    <td contenteditable="true">Donnée 6</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                ...
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-item edit-action">Modifier</li>
                                <li class="dropdown-item delete-action">Supprimer</li>
                            </ul>
                        </div>
                        <div class="edit-menu">
                            <button class="btn btn-primary save-action">Enregistrer</button>
                            <button class="btn btn-secondary cancel-action">Annuler</button>
                        </div>
                    </td>
                </tr>
                <tr class="table-row">
                    <td contenteditable="false">Donnée 7</td>
                    <td contenteditable="true">Donnée 8</td>
                    <td contenteditable="true">Donnée 9</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                ...
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-item edit-action">Modifier</li>
                                <li class="dropdown-item delete-action">Supprimer</li>
                            </ul>
                        </div>
                        <div class="edit-menu">
                            <button class="btn btn-primary save-action">Enregistrer</button>
                            <button class="btn btn-secondary cancel-action">Annuler</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fonction pour gérer les actions lorsque l'option "Modifier" est sélectionnée
        function handleEditAction(event) {
            const row = event.target.closest('tr');
            const editMenu = row.querySelector('.edit-menu');
            const columns = row.querySelectorAll('td:not(:first-child)');
            const dropdownMenu = row.querySelector('.dropdown-menu');

            editMenu.classList.add('active');
            dropdownMenu.classList.remove('show');

            columns.forEach((column) => {
                column.setAttribute('contenteditable', 'true');
            });
        }

        // Fonction pour gérer les actions lorsque l'option "Annuler" est sélectionnée
        function handleCancelAction(event) {
            const row = event.target.closest('tr');
            const editMenu = row.querySelector('.edit-menu');
            const columns = row.querySelectorAll('td:not(:first-child)');

            editMenu.classList.remove('active');

            columns.forEach((column) => {
                column.setAttribute('contenteditable', 'false');
            });
        }

        // Fonction pour gérer les actions lorsque l'option "Enregistrer" est sélectionnée
        function handleSaveAction(event) {
            const row = event.target.closest('tr');
            const editMenu = row.querySelector('.edit-menu');
            const columns = row.querySelectorAll('td:not(:first-child)');
            const values = [];

            editMenu.classList.remove('active');

            columns.forEach((column) => {
                values.push(column.textContent);
            });

            // Appeler la fonction PHP avec les valeurs des colonnes (values)
            // Remplacez "abc.php" par le chemin vers votre fichier PHP
            // avec la fonction de sauvegarde appropriée
            fetch('abc.php', {
                method: 'POST',
                body: JSON.stringify(values),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Réaliser des actions supplémentaires après la sauvegarde si nécessaire
            })
            .catch(error => {
                console.error(error);
                // Gérer les erreurs de la sauvegarde si nécessaire
            });

            columns.forEach((column) => {
                column.setAttribute('contenteditable', 'false');
            });
        }

        // Fonction pour gérer les actions lorsque l'option "Supprimer" est sélectionnée
        function handleDeleteAction(event) {
            const row = event.target.closest('tr');
            const firstColumn = row.querySelector('td:first-child');
            const value = firstColumn.textContent;

            // Appeler la fonction PHP pour supprimer les données avec la valeur de la première colonne (value)
            // Remplacez "delete.php" par le chemin vers votre fichier PHP
            // avec la fonction de suppression appropriée
            fetch('delete.php', {
                method: 'POST',
                body: JSON.stringify({ value: value }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Réaliser des actions supplémentaires après la suppression si nécessaire
            })
            .catch(error => {
                console.error(error);
                // Gérer les erreurs de la suppression si nécessaire
            });

            row.remove();
        }

        // Ajouter les gestionnaires d'événements pour les actions de modification, annulation et sauvegarde
        const editActions = document.querySelectorAll('.edit-action');
        editActions.forEach((editAction) => {
            editAction.addEventListener('click', handleEditAction);
        });

        const cancelActions = document.querySelectorAll('.cancel-action');
        cancelActions.forEach((cancelAction) => {
            cancelAction.addEventListener('click', handleCancelAction);
        });

        const saveActions = document.querySelectorAll('.save-action');
        saveActions.forEach((saveAction) => {
            saveAction.addEventListener('click', handleSaveAction);
        });

        // Ajouter le gestionnaire d'événement pour l'action de suppression
        const deleteActions = document.querySelectorAll('.delete-action');
        deleteActions.forEach((deleteAction) => {
            deleteAction.addEventListener('click', handleDeleteAction);
        });
    </script>
</body>
</html>
