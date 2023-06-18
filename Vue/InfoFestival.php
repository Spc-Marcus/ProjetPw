    <?php include "Template/headerUser.php"; ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Info Festival</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Montserrat', sans-serif;
            }
            
            .card-title {
                font-size: 32px;
                font-weight: bold;
                color: white;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
                padding: 10px;
                text-align: center;
                margin-bottom: 20px;
            }

            .card-body {
                font-size: 20px;
            }

            .card-text {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <?php
        require_once("../DAO/FestivalDAO.php");
        require_once("../Model/Festival.php");

        $dbFile = '../DB/Donne.db';
        $pdo = new PDO('sqlite:' . $dbFile);
        $dao = new FestivalDAO($pdo);

        if(isset($_POST['festival_id'])){
            $festivalId = $_POST['festival_id'];
            $festival = $dao->getById($festivalId);

            if($festival){
                echo '<div class="container">';
                echo '<div class="card mt-5">';
                echo '<img class="card-img-top" src="../Image/'.$festival->getPhoto().'" alt="Image du festival">';
                echo '<h1 class="card-title text-center">'.$festival->getNom().'</h1>';
                echo '<div class="card-body">';
                echo '<p class="card-text"><strong>Date de début:</strong> '.$festival->getDate_debut().'</p>';
                echo '<p class="card-text"><strong>Date de fin:</strong> '.$festival->getDate_fin().'</p>';
                echo '<p class="card-text"><strong>Localisation:</strong> '.$festival->getLocalisation().'</p>';
                if(isset($_SESSION['utilisateur'])){
                    echo '<div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="Proposition" data-bs-toggle="dropdown" aria-expanded="false">J\'y vais</button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="Proposition">
                    <li>
                        <a class="dropdown-item" href="#" onclick="openProposeTrajetForm()">Je propose un trajet</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="openRechercheTrajetForm()">Je recherche un trajet</a>
                    </li>
                    </ul>
                </div>
                
                <div id="proposeTrajetForm" style="display: none;">
                    <form action="../Controleur/CreerTrajet.php" method="post">
                    <input type="hidden" name="festivalId" value="' . $festivalId . '">
                    <input type="hidden" name="userId" value="' . $_SESSION['utilisateur']->getId() . '">
                    <label for="vehicule">Type de véhicule :</label>
                    <input type="text" id="vehicule" name="vehicule" required><br>
                
                    <label for="places">Nombre de places disponibles :</label>
                    <input type="number" id="places" name="places" required><br>
                
                    <label for="dateAller">Date d\'aller :</label>
                    <input type="date" id="dateAller" name="aller" required><br>
                
                    <label for="dateRetour">Date de retour :</label>
                    <input type="date" id="dateRetour" name="retour"><br>
                
                    <label for="localisation">Localisation :</label>
                    <input type="text" id="localisation" name="localisation" required><br>
                
                    <input type="submit" value="Envoyer" id=sumitBtnTrajet"">
                    </form>
                </div>
                
                <div id="rechercheTrajetForm" style="display: none;">
                    <form action="../Controleur/CreerRecherche.php" method="post">
                    <input type="hidden" name="festivalId" value="' . $festivalId . '">
                    <input type="hidden" name="userId" value="' . $_SESSION['utilisateur']->getId() . '">
                    <label for="dateAller">Date d\'aller :</label>
                    <input type="date" id="dateAller" name="dateAller" required><br>
                
                    <label for="dateRetour">Date de retour :</label>
                    <input type="date" id="dateRetour" name="dateRetour"  required><br>
                
                    <label for="rechercheAller">Rechercher un trajet pour l\'aller :</label>
                    <input type="checkbox" id="rechercheAller" name="rechercheAller" onchange="verif()"><br>
                
                    <label for="rechercheRetour">Rechercher un trajet pour le retour :</label>
                    <input type="checkbox" id="rechercheRetour" name="rechercheRetour" onchange="verif()"><br>
                
                    <label for="localisation">Localisation :</label>
                    <input type="text" id="localisation" name="localisation" required><br>
                
                    <input type="submit" value="Envoyer" id="submitBtnRecherche" disabled>
                    </form>
                </div>
                
                <script>
                    function openProposeTrajetForm() {
                    document.getElementById("proposeTrajetForm").style.display = "block";
                    document.getElementById("rechercheTrajetForm").style.display = "none";
                    }
                
                    function openRechercheTrajetForm() {
                    document.getElementById("rechercheTrajetForm").style.display = "block";
                    document.getElementById("proposeTrajetForm").style.display = "none";
                    }

                    function verif(){
                        var allerCheckbox = document.getElementById("rechercheAller");
                        var retourCheckbox = document.getElementById("rechercheRetour");
                        var submitBtn = document.getElementById("submitBtnRecherche");
                        
                        if(!allerCheckbox.checked&&!retourCheckbox.checked){
                            submitBtn.disabled=true;
                        }
                        else{
                            submitBtn.removeAttribute("disabled");
                        }
                    }
                </script>
                ';}
                echo '</div>';

                echo '</div>';
                echo '</div>';
            }
        }
        ?>

    </body>
    </html>
