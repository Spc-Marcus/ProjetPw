    <?php include "Template/headerUser.php"
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Festi-Voiturage</title>
            <style>
            

            .container-texte {
                margin: 20px;
                background-color: #063a47;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
                text-align: center;
            }

            h1 {
                margin-bottom: 30px;
                font-size: 36px;
                font-weight: bold;
            }

            p {
                font-size: 18px;
                line-height: 1.5;
                margin-bottom: 20px;
            }

            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
                padding: 10px 20px;
                font-size: 18px;
                border-radius: 5px;
            }

            .btn-secondary {
                background-color: #6c757d;
                border-color: #6c757d;
                padding: 10px 20px;
                font-size: 18px;
                border-radius: 5px;
            }

            .btn-primary:hover, .btn-secondary:hover {
                opacity: 0.8;
            }
        </style>
        </head>
        <body>
        <div class="container-texte">
            <h1>Bienvenue sur Festi-Voiturage</h1>
            <h1>Partagez vos trajets vers les festivals avec Festi-Voiturage</h1>
            <p>
                Festi-Voiturage est la plateforme idéale pour tous les festivaliers qui souhaitent se rendre à des festivals à travers la France en minimisant leur impact sur l'environnement. En partageant vos trajets avec d'autres festivaliers, vous contribuez à réduire le nombre de véhicules sur les routes et à créer une communauté de partage conviviale.
            </p>
            <p>
                Que vous soyez à la recherche d'un véhicule pour vous rendre à un festival ou que vous soyez prêt à partager votre propre trajet, Festi-Voiturage vous met en relation avec des personnes partageant les mêmes intérêts. Trouvez le compagnon de voyage idéal et profitez d'une expérience unique en route vers votre festival préféré.
            </p>
            <p>
                Comment ça marche ? C'est simple ! Inscrivez-vous gratuitement, recherchez les trajets disponibles ou proposez votre propre trajet en indiquant les détails de votre voyage. Vous pouvez discuter avec d'autres festivaliers intéressés, convenir des détails pratiques et organiser votre covoiturage en toute simplicité.
            </p>
            <p>
                Rejoignez dès maintenant la communauté Festi-Voiturage et découvrez une nouvelle façon de voyager vers les festivals en combinant économie, convivialité et respect de l'environnement. Ensemble, rendons chaque trajet vers un festival aussi mémorable que l'événement lui-même.
            </p>
            <p>
                <?php
                if(!isset($_SESSION['utilisateur'])){
                    echo'<a href="Login.php" class="btn btn-primary">Inscrivez-vous gratuitement</a>';
                    echo'<a href="Login.php" class="btn btn-secondary">Connectez-vous</a>';
                }
                ?>
                
            </p>
        </div>
        </body>
    </html>