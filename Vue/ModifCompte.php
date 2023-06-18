<?php include "Template/headerUser.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier l'utilisateur</title>
    <link href="Css/style.css" rel="stylesheet">
    <link href="Css/bootstrap.css" rel="stylesheet">
    <style>
        .form-control[readonly] {
            background-color: #e9ecef;
        }
    </style>
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
        <h1>Modifier l'utilisateur</h1>
        <form id="form-modifier" action="../DAO/FestivalierDAO.php" method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $_SESSION['utilisateur']->getNom(); ?>" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $_SESSION['utilisateur']->getPrenom(); ?>" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <div class="input-group">
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['utilisateur']->getEmail(); ?>" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="ancien-mdp" class="form-label">Ancien mot de passe</label>
                <input type="password" class="form-control" id="ancien-mdp" name="ancien-mdp">
            </div>
            <div class="mb-3" id="nouveau-mdp" style="display: none;">
                <label for="nouveau-mdp" class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="nouveau-mdp" name="nouveau-mdp">
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" id="modifier-general">Modifier</button>
            </div>
            <button type="submit" class="btn btn-primary" id="enregistrer" disabled>Enregistrer</button>
            <button type="button" class="btn btn-secondary" id="annuler">Annuler</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#notification-toast').hide(); // Masquer la notification par défaut

            $('#modifier-general').click(function() {
                $('#nom').prop('readonly', false).removeClass('bg-light');
                $('#prenom').prop('readonly', false).removeClass('bg-light');
                $('#email').prop('readonly', false).removeClass('bg-light');
                $('#ancien-mdp').prop('readonly', false).removeClass('bg-light');
                $('#nouveau-mdp').show();
                $('#enregistrer').prop('disabled', false);
            });

            $('#annuler').click(function() {
                $('#nom').prop('readonly', true).addClass('bg-light');
                $('#prenom').prop('readonly', true).addClass('bg-light');
                $('#email').prop('readonly', true).addClass('bg-light');
                $('#ancien-mdp').prop('readonly', true).addClass('bg-light');
                $('#nouveau-mdp').hide();
                $('#ancien-mdp').val('');
                $('#nouveau-mdp').val('');
                $('#enregistrer').prop('disabled', true);
            });

            $('#form-modifier').submit(function(e) {
                e.preventDefault(); // Empêcher la soumission du formulaire

                var nom = $('#nom').val();
                var prenom = $('#prenom').val();
                var email = $('#email').val();
                var ancienMdp = $('#ancien-mdp').val();
                var nouveauMdp = $('#nouveau-mdp').val();

                if (nom.trim() === '' || prenom.trim() === '' || email.trim() === '') {
                    $('#notification-toast').show();
                } else {
                    // Vérifier si le mot de passe est requis pour l'enregistrement
                    var mdpRequis = false;
                    if (ancienMdp.trim() !== '' || nouveauMdp.trim() !== '') {
                        mdpRequis = true;
                    }

                    if (mdpRequis) {
                        // Afficher une boîte de dialogue de confirmation avec l'ancien mot de passe
                        // Si la confirmation est réussie, continuer avec la sauvegarde
                        var confirmation = confirm("Veuillez confirmer en entrant votre ancien mot de passe.");
                        if (confirmation) {
                            // Effectuer les actions de sauvegarde dans la base de données
                            // ...
                            // Redirection vers une autre page ou traitement supplémentaire
                        }
                    } else {
                        // Effectuer les actions de sauvegarde dans la base de données
                        // ...
                        // Redirection vers une autre page ou traitement supplémentaire
                    }
                }
            });
        });
    </script>
</body>
</html>
        