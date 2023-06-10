<!DOCTYPE html>
<html>
<head>
    <title>Connexion et Enregistrement</title>
    <link href="../Css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 100px;
        }

        .form-switch {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-switch input[type="radio"] {
            display: none;
        }

        .form-switch label {
            display: inline-block;
            background-color: #ddd;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-switch input[type="radio"]:checked + label {
            background-color: #bbb;
        }

        .form-switch input[type="radio"]:checked ~ .form-toggle {
            display: none;
        }

        .form-toggle {
            display: none;
        }

        .form-toggle.active {
            display: block;
        }

        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #bbb;
            border-radius: 50%;
            box-shadow: 0 0 0 1px #fff;
        }

        .back-link svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }
    </style>
</head>
<body>
<a href="FestiVoiturage.php" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M11.354 12.646a.5.5 0 0 0 0-.708L7.707 8l3.647-3.646a.5.5 0 0 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708 0z"/>
    </svg>
</a>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="form-container">
                <div class="form-switch">
                    <input type="radio" id="email-radio" name="form-switch" checked>
                    <label for="email-radio">Connexion</label>
                    <input type="radio" id="register-radio" name="form-switch">
                    <label for="register-radio">Enregistrement</label>
                </div>

                <form id="email-form" class="form-toggle active">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de passe:</label>
                        <input type="password" class="form-control" id="mdp" name="mdp" required>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="Se connecter">
                    </div>
                </form>

                <form id="register-form" class="form-toggle">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom:</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom:</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="register-email" name="email" required>
                        <div id="email-status"></div> <!-- Ajout de l'élément pour afficher le statut de vérification de l'e-mail -->
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de passe:</label>
                        <input type="password" class="form-control" id="register-password" name="mdp" required>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="S'enregistrer">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Inclusion de jQuery -->
<script>
    const emailRadio = document.getElementById('email-radio');
    const registerRadio = document.getElementById('register-radio');
    const emailForm = document.getElementById('email-form');
    const registerForm = document.getElementById('register-form');

    emailRadio.addEventListener('click', function() {
        emailForm.classList.add('active');
        registerForm.classList.remove('active');
    });

    registerRadio.addEventListener('click', function() {
        emailForm.classList.remove('active');
        registerForm.classList.add('active');
    });

    $(document).ready(function() {
        // Écouteur d'événement pour le champ email lors de la saisie
        $('#register-email').on('input', function() {
            var email = $(this).val();

            // Appel AJAX vers le fichier PHP pour vérifier l'existence de l'e-mail
            $.ajax({
                url: '../../Controleur/verifier_email.php', // Remplacez par le chemin vers votre fichier PHP de vérification
                type: 'POST',
                data: { email: email },
                dataType: 'json',
                success: function(response) {
                    // Affichage du résultat de la vérification
                    if (response.exists) {
                        $('#email-status').html('<span style="color: red;">&#x2718;</span> Cet e-mail existe déjà');
                    } else {
                        $('#email-status').html('<span style="color: green;">&#x2714;</span> Cet e-mail est disponible');
                    }
                },
                error: function(xhr, status, error) {
                    // Gestion des erreurs
                    console.log(error);
                }
            });
        });
    });
</script>
</body>
</html>
